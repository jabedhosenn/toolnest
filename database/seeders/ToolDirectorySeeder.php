<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tool;
use App\Models\ToolTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ToolDirectorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Text Tools', 'slug' => 'text-tools', 'description' => 'Write, count, and transform text.', 'icon' => 'text', 'sort_order' => 1],
            ['name' => 'Fancy Text', 'slug' => 'fancy-text', 'description' => 'Create expressive text styles for sharing.', 'icon' => 'sparkles', 'sort_order' => 2],
            ['name' => 'Image Tools', 'slug' => 'image-tools', 'description' => 'Resize, compress, and convert images.', 'icon' => 'image', 'sort_order' => 3],
            ['name' => 'PDF Tools', 'slug' => 'pdf-tools', 'description' => 'Merge, split, and compress PDF documents.', 'icon' => 'file', 'sort_order' => 4],
            ['name' => 'File Converter', 'slug' => 'file-converter', 'description' => 'Convert files between common formats.', 'icon' => 'files', 'sort_order' => 5],
            ['name' => 'Video Tools', 'slug' => 'video-tools', 'description' => 'Prepare and convert video files.', 'icon' => 'video', 'sort_order' => 6],
            ['name' => 'Audio Tools', 'slug' => 'audio-tools', 'description' => 'Convert and shape audio.', 'icon' => 'audio', 'sort_order' => 7],
            ['name' => 'Developer Tools', 'slug' => 'developer-tools', 'description' => 'Format and inspect code and data.', 'icon' => 'code', 'sort_order' => 8],
            ['name' => 'Utilities', 'slug' => 'utilities', 'description' => 'Useful helpers for everyday tasks.', 'icon' => 'zap', 'sort_order' => 9],
        ];
        $categoryIds = [];

        foreach ($categories as $attributes) {
            $category = Category::updateOrCreate(
                ['slug' => $attributes['slug']],
                [...$attributes, 'is_active' => true],
            );
            $categoryIds[$category->slug] = $category->id;
        }

        $tools = [
            ['name' => 'Word Counter', 'slug' => 'word-counter', 'category' => 'text-tools', 'description' => 'Count words, characters, and sentences in a few seconds.', 'icon' => 'text', 'popular' => true, 'featured' => true, 'tags' => ['word count', 'characters', 'text']],
            ['name' => 'Case Converter', 'slug' => 'case-converter', 'category' => 'text-tools', 'description' => 'Switch text between sentence, title, upper, and lower case.', 'icon' => 'wand', 'popular' => true, 'featured' => false, 'tags' => ['text', 'case', 'convert']],
            ['name' => 'Fancy Text Generator', 'slug' => 'fancy-text-generator', 'category' => 'fancy-text', 'description' => 'Give a short message a distinctive style for sharing.', 'icon' => 'sparkles', 'popular' => true, 'featured' => false, 'tags' => ['fancy text', 'generator', 'social']],
            ['name' => 'PDF Merger', 'slug' => 'pdf-merger', 'category' => 'pdf-tools', 'description' => 'Bring multiple PDF documents together into one file.', 'icon' => 'files', 'popular' => true, 'featured' => false, 'tags' => ['pdf', 'merge', 'documents']],
            ['name' => 'PDF Compressor', 'slug' => 'pdf-compressor', 'category' => 'pdf-tools', 'description' => 'Reduce a PDF’s file size for easier sharing and storage.', 'icon' => 'file', 'popular' => true, 'featured' => true, 'tags' => ['pdf', 'compress', 'documents']],
            ['name' => 'Image Compressor', 'slug' => 'image-compressor', 'category' => 'image-tools', 'description' => 'Make image files smaller while keeping them useful.', 'icon' => 'image', 'popular' => true, 'featured' => false, 'tags' => ['image', 'compress', 'photo']],
            ['name' => 'Image Converter', 'slug' => 'image-converter', 'category' => 'image-tools', 'description' => 'Convert images between common file formats.', 'icon' => 'image', 'popular' => true, 'featured' => true, 'tags' => ['image', 'convert', 'formats']],
            ['name' => 'JSON Formatter', 'slug' => 'json-formatter', 'category' => 'developer-tools', 'description' => 'Format and organize JSON so it’s easier to read.', 'icon' => 'code', 'popular' => true, 'featured' => false, 'tags' => ['json', 'format', 'developer']],
            ['name' => 'Markdown Preview', 'slug' => 'markdown-preview', 'category' => 'developer-tools', 'description' => 'Preview Markdown as a clean, readable document.', 'icon' => 'code', 'popular' => false, 'featured' => false, 'tags' => ['markdown', 'preview', 'developer']],
            ['name' => 'PDF Splitter', 'slug' => 'pdf-splitter', 'category' => 'pdf-tools', 'description' => 'Separate selected pages into smaller PDF files.', 'icon' => 'files', 'popular' => false, 'featured' => false, 'tags' => ['pdf', 'split', 'documents']],
            ['name' => 'SVG to PNG', 'slug' => 'svg-to-png', 'category' => 'image-tools', 'description' => 'Convert a vector image into a widely supported PNG.', 'icon' => 'image', 'popular' => false, 'featured' => false, 'tags' => ['svg', 'png', 'image']],
            ['name' => 'Audio Converter', 'slug' => 'audio-converter', 'category' => 'audio-tools', 'description' => 'Convert audio files between common formats.', 'icon' => 'audio', 'popular' => false, 'featured' => false, 'tags' => ['audio', 'convert', 'formats']],
        ];

        foreach ($tools as $sortOrder => $attributes) {
            $tool = Tool::updateOrCreate(
                ['slug' => $attributes['slug']],
                [
                    'category_id' => $categoryIds[$attributes['category']],
                    'name' => $attributes['name'],
                    'description' => $attributes['description'],
                    'icon' => $attributes['icon'],
                    'route_name' => 'tools.'.$attributes['slug'],
                    'component_identifier' => $attributes['slug'],
                    'is_popular' => $attributes['popular'],
                    'is_featured' => $attributes['featured'],
                    'is_active' => true,
                    'sort_order' => $sortOrder + 1,
                ],
            );

            foreach ($attributes['tags'] as $name) {
                ToolTag::updateOrCreate(
                    ['tool_id' => $tool->id, 'slug' => Str::slug($name)],
                    ['name' => $name],
                );
            }
        }
    }
}
