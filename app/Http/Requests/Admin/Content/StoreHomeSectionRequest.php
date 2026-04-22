<?php

namespace App\Http\Requests\Admin\Content;

use App\Models\HomeSection;
use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHomeSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage_pages') ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'section_type' => ['required', 'string', Rule::in(array_keys(HomeSection::sectionTypes()))],
            'section_key' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_-]+$/', 'unique:home_sections,section_key'],
            'image' => ['nullable', 'image', 'max:4096'],
            'cta_link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["title.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["subtitle.$locale"] = ['nullable', 'string', 'max:500'];
            $rules["content.$locale"] = ['nullable', 'string'];
            $rules["cta_label.$locale"] = ['nullable', 'string', 'max:100'];
        }

        return array_merge($rules, $this->typeSpecificRules());
    }

    protected function typeSpecificRules(): array
    {
        $type = $this->input('section_type');

        $titleRules = $this->requiredForAllLocales('title', ['required', 'string', 'max:255']);
        $contentRules = $this->requiredForAllLocales('content', ['required', 'string']);
        $ctaRules = $this->requiredForAllLocales('cta_label', ['required', 'string', 'max:100']);

        return match ($type) {
            HomeSection::TYPE_HERO => [
                ...$titleRules,
                ...$contentRules,
                ...$ctaRules,
                'cta_link' => ['required', 'string', 'max:255'],
            ],
            HomeSection::TYPE_ABOUT_INTRO => [
                ...$titleRules,
                ...$contentRules,
            ],
            HomeSection::TYPE_FEATURED_PROJECTS,
            HomeSection::TYPE_SERVICES,
            HomeSection::TYPE_TESTIMONIALS => $titleRules,
            HomeSection::TYPE_CTA_BLOCK => [
                ...$titleRules,
                ...$contentRules,
                ...$ctaRules,
                'cta_link' => ['required', 'string', 'max:255'],
            ],
            default => [],
        };
    }

    protected function requiredForAllLocales(string $attribute, array $constraints): array
    {
        $rules = [];

        foreach (Locale::all() as $locale) {
            $rules["{$attribute}.{$locale}"] = $constraints;
        }

        return $rules;
    }
}
