@extends('layouts.admin')
@section('content')
<h2 class="text-2xl font-semibold mb-4">Site Settings</h2>
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}" class="space-y-4 bg-white border rounded p-6">@csrf @method('PUT')
<x-admin.translatable-tabs name="site_name" label="Site name" :values="$setting->site_name ?? []" required :locales="$locales" />
<x-admin.translatable-tabs name="tagline" label="Tagline" :values="$setting->tagline ?? []" :locales="$locales" />
<div class="grid md:grid-cols-3 gap-3"><input name="contact_email" value="{{ old('contact_email',$setting->contact_email) }}" class="border rounded px-3 py-2" placeholder="Email"><input name="phone" value="{{ old('phone',$setting->phone) }}" class="border rounded px-3 py-2" placeholder="Phone"><select name="default_locale" class="border rounded px-3 py-2">@foreach($locales as $locale)<option value="{{ $locale }}" @selected(old('default_locale',$setting->default_locale)===$locale)>{{ strtoupper($locale) }}</option>@endforeach</select></div>
<input name="map_embed_url" value="{{ old('map_embed_url',$setting->map_embed_url) }}" class="w-full border rounded px-3 py-2" placeholder="Map embed URL">
<x-admin.translatable-tabs name="address" label="Address" :values="$setting->address ?? []" type="textarea" :locales="$locales" />
<div class="grid md:grid-cols-2 gap-3"><input type="file" name="logo" class="border rounded px-3 py-2"><input type="file" name="favicon" class="border rounded px-3 py-2"></div>
<div class="grid md:grid-cols-3 gap-3"><input name="social_links[linkedin]" value="{{ old('social_links.linkedin',$setting->social_links['linkedin'] ?? '') }}" class="border rounded px-3 py-2" placeholder="LinkedIn"><input name="social_links[instagram]" value="{{ old('social_links.instagram',$setting->social_links['instagram'] ?? '') }}" class="border rounded px-3 py-2" placeholder="Instagram"><input name="social_links[github]" value="{{ old('social_links.github',$setting->social_links['github'] ?? '') }}" class="border rounded px-3 py-2" placeholder="GitHub"></div>
<x-admin.translatable-tabs name="seo_defaults.title" label="Default SEO title" :values="$setting->seo_defaults['title'] ?? []" :locales="$locales" />
<x-admin.translatable-tabs name="seo_defaults.description" label="Default SEO description" type="textarea" :values="$setting->seo_defaults['description'] ?? []" :locales="$locales" />
<input name="seo_defaults[og_image]" value="{{ old('seo_defaults.og_image',$setting->seo_defaults['og_image'] ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="Default OG image path">
<x-admin.translatable-tabs name="footer_content" label="Footer content" type="textarea" :values="$setting->footer_content ?? []" :locales="$locales" />
<button class="px-4 py-2 bg-slate-900 text-white rounded">Save settings</button>
</form>
@endsection
