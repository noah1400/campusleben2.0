@extends('layouts.app')

@section('css')
<style>
.page_content {
    line-height: 1.5em;
    font-size: 1.1em;
}

.page_content ul {
    list-style-type: disc;
    margin: 1em 0 -0.5em 1.25em !important;
}

.page_content li:has( input[type=checkbox]) {
    list-style-type: none;
    margin-left: -1em !important;
}

.page_content ol {
    list-style-type: decimal;
    margin: 1em 0 -0.5em 1.25em !important;
}

.page_content li {
    margin: 0 !important;
}

.page_content p {
    --tw-text-opacity: 1; color: rgb(107 114 128 / var(--tw-text-opacity));
    margin: 0.5em 0 0 0 !important;
    line-height: 2rem !important;
    font-size: 1.25rem !important;
}

.page_content hr {
    margin: 0 0 0 0 !important;
}

.page_content a {
    color: #3490dc;
    text-decoration: underline;
}

.page_content blockquote {
    border-left: 5px solid #ccc;
    margin: 1.5em 10px !important;
    padding: 0.5em 10px;
}

.page_content h1,
.page_content h2,
.page_content h3,
.page_content h4,
.page_content h5,
.page_content h6 {
    margin: 0 0 0.5rem 0 !important;
    line-height: 1.2;
    font-weight: 800;
    text-align: center;
    color: rgb(17 24 39 / var(--tw-text-opacity));
    display: block;
}

.page_content h1 {
    font-size: 2.25rem;
    line-height: 2.5rem;
    letter-spacing: -0.025rem;
}

.page_content h2 {
    font-size: 2.05rem;
    line-height: 2.55rem;
    letter-spacing: -0.025rem;
}

.page_content h3 {
    font-size: 1.7rem;
    line-height: 2.6rem;
    letter-spacing: -0.025rem;
}

.page_content h4 {
    font-size: 1.5rem;
    line-height: 2.65rem;
    letter-spacing: -0.023rem;
}

.page_content h5 {
    font-size: 1.4rem;
    line-height: 2.8rem;
    letter-spacing: -0.020rem;
}

.page_content h6 {
    font-size: 1.4rem;
    line-height: 2.9rem;
    letter-spacing: 0;
}

.page_content pre {
    font: 1em/normal 'Roboto Mono', 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;
    margin-bottom: 1.5rem !important;
    overflow: auto;
}

.page_content pre > code {
    display: block;
    padding: 1rem 1.5rem;
    white-space: pre;
}

.page_content code {
    font: 1em/normal 'Roboto Mono', 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;
    margin: 0 0.2rem;
    background: #F1F1F1;
    border: 1px solid #E1E1E1;
    border-radius: 4px;
}
</style>
@endsection

@section('content')
    <div class="relative py-16 bg-white overflow-hidden min-h-screen">
        <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:h-full lg:w-full">
            <div class="relative h-full text-lg max-w-prose mx-auto" aria-hidden="true">
                <svg class="absolute top-12 left-full transform translate-x-32" width="404" height="384" fill="none"
                    viewBox="0 0 404 384">
                    <defs>
                        <pattern id="74b3fd99-0a6f-4271-bef2-e80eeafdf357" x="0" y="0" width="20"
                            height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                                fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#74b3fd99-0a6f-4271-bef2-e80eeafdf357)" />
                </svg>
                <svg class="absolute top-3/4 right-full transform -translate-y-1/2 -translate-x-32" width="404"
                    height="384" fill="none" viewBox="0 0 404 384">
                    <defs>
                        <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20"
                            height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                                fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
                </svg>
            </div>
        </div>
        <div class="relative px-4 sm:px-6 lg:px-8">
            @if ($location->image)
            <div class="mt-6 mb-2 prose prose-indigo prose-lg text-gray-500 mx-auto">
                <figure>
                    <img class="w-fit mx-auto h-72" src="{{ asset('storage/'.$location->image) }}"
                        alt="">
                </figure>
            </div>
            @endif
            <div class="page_content text-lg max-w-prose mx-auto">
                <h1>{{ $location->name }}</h1>
                @markdown($location->page_content)
            </div>
        </div>
    </div>
@endsection
