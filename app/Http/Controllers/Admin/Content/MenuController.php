<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\StoreMenuRequest;
use App\Http\Requests\Admin\Content\StoreMenuItemRequest;
use App\Http\Requests\Admin\Content\UpdateMenuRequest;
use App\Http\Requests\Admin\Content\UpdateMenuItemRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $menus = Menu::query()
            ->when($request->string('search')->toString(), fn ($q, $s) => $q->where('name', 'like', "%{$s}%")->orWhere('location', 'like', "%{$s}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.content.menus.index', compact('menus'));
    }

    public function create(): View
    {
        return view('admin.content.menus.form', ['menu' => new Menu()]);
    }

    public function store(StoreMenuRequest $request): RedirectResponse
    {
        $menu = Menu::create($request->validated());

        return redirect()->route('admin.menus.edit', $menu)->with('status', __('messages.menu_created'));
    }

    public function edit(Menu $menu): View
    {
        $menu->load(['items.children']);

        return view('admin.content.menus.form', [
            'menu' => $menu,
            'pages' => Page::published()->get(),
            'items' => $menu->items()->with('children')->whereNull('parent_id')->get(),
        ]);
    }

    public function update(UpdateMenuRequest $request, Menu $menu): RedirectResponse
    {
        $menu->update($request->validated());

        return back()->with('status', __('messages.menu_updated'));
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();

        return back()->with('status', __('messages.menu_deleted'));
    }

    public function storeItem(StoreMenuItemRequest $request, Menu $menu): RedirectResponse
    {
        $menu->items()->create($request->validated());

        return back()->with('status', __('messages.menu_item_created'));
    }

    public function updateItem(UpdateMenuItemRequest $request, Menu $menu, MenuItem $item): RedirectResponse
    {
        abort_unless($item->menu_id === $menu->id, 404);
        $item->update($request->validated());

        return back()->with('status', __('messages.menu_item_updated'));
    }

    public function destroyItem(Menu $menu, MenuItem $item): RedirectResponse
    {
        abort_unless($item->menu_id === $menu->id, 404);
        $item->delete();

        return back()->with('status', __('messages.menu_item_deleted'));
    }
}
