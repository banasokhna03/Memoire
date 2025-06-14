@if ($paginator->hasPages())
    <nav class="flex items-center space-x-2">

        {{-- Lien vers la page précédente --}}
        @if ($paginator->onFirstPage())
            {{-- Si c'est la première page, le bouton est désactivé --}}
            <span class="px-3 py-1 rounded-lg border border-gray-300 text-gray-500 cursor-not-allowed">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            {{-- Sinon, c'est un lien cliquable --}}
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-50">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Éléments de pagination (numéros de page et points de suspension) --}}
        @foreach ($elements as $element)
            {{-- "Points de suspension" (...) --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Les numéros de page --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{-- Page actuelle : fond violet, texte blanc --}}
                        <span aria-current="page" class="px-3 py-1 rounded-lg bg-purple-600 text-white font-medium">
                            {{ $page }}
                        </span>
                    @else
                        {{-- Autres pages : bordure grise, texte gris/violet au survol --}}
                        <a href="{{ $url }}" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Lien vers la page suivante --}}
        @if ($paginator->hasMorePages())
            {{-- S'il y a une page suivante, c'est un lien cliquable --}}
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-50">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            {{-- Sinon, le bouton est désactivé --}}
            <span aria-disabled="true" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-500 cursor-not-allowed">
                <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif