{{-- resources/views/components/trix-input.blade.php --}}
@props([
    'id' => 'trix-' . uniqid(),
    'name' => '',
    'value' => '',
    'wire:model' => null,
])

@php
    $wireModel = $attributes->wire('model')->value();
@endphp

<div wire:ignore>
    <input
        type="hidden"
        id="{{ $id }}_input"
        name="{{ $name }}"
        value="{{ $value }}"
    >

    <trix-editor
        input="{{ $id }}_input"
        class="trix-content"
        x-data="{
            value: @entangle($wireModel).live,
            editor: null,
        }"
        x-init="
            editor = $el.editor;

            // Set initial value
            if (value && !editor.getDocument().toString().trim()) {
                editor.loadHTML(value);
            }

            // Listen for changes from Trix
            $el.addEventListener('trix-change', function(e) {
                value = e.target.value;
            });

            // Watch for external changes
            $watch('value', (newValue) => {
                if (newValue !== editor.element.value) {
                    editor.loadHTML(newValue || '');
                }
            });
        "
    ></trix-editor>
</div>

@once
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        /* Ensure Trix toolbar displays correctly */
        trix-toolbar {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            border-bottom: none;
            border-radius: 0.375rem 0.375rem 0 0;
            padding: 0.5rem;
        }

        trix-editor {
            border: 1px solid #d1d5db;
            border-radius: 0 0 0.375rem 0.375rem;
            padding: 0.75rem;
            min-height: 150px;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Dark mode support */
        .dark trix-toolbar {
            background-color: #374151;
            border-color: #4b5563;
        }

        .dark trix-editor {
            background-color: #1f2937;
            border-color: #4b5563;
            color: #f3f4f6;
        }

        /* Fix toolbar buttons */
        trix-toolbar .trix-button-group {
            display: inline-flex;
            margin-right: 0.5rem;
        }

        trix-toolbar .trix-button {
            background-color: white;
            border: 1px solid #d1d5db;
            padding: 0.25rem 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        trix-toolbar .trix-button:hover {
            background-color: #e5e7eb;
        }

        trix-toolbar .trix-button.trix-active {
            background-color: #dbeafe;
            border-color: #3b82f6;
        }

        .dark trix-toolbar .trix-button {
            background-color: #4b5563;
            border-color: #6b7280;
            color: #f3f4f6;
        }

        .dark trix-toolbar .trix-button:hover {
            background-color: #6b7280;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        // Disable file attachments if you don't have upload handling
        document.addEventListener('trix-file-accept', function(event) {
            event.preventDefault();
            alert('File attachments are not enabled. Please set up file upload handling.');
        });
    </script>
    @endpush
@endonce
