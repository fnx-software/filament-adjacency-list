<x-filament-forms::field-wrapper
    class="filament-navigation"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    @php
        $treeId = $getId();
        
        $hasRulers = $hasRulers();
        $isAddable = $isAddable();
        $isDeletable = $isDeletable();
        $isDisabled = $isDisabled();
        $isEditable = $isEditable();
        $isIndentable = $isIndentable();
        $isReorderable = $isReorderable();
        $isCollapsible = $isCollapsible();
        $isCollapsed = $isCollapsed();
        
        $maxDepth = $getMaxDepth();
        
        $addAction = $getAction('add');
        $itemActions = [$getAction('addChild'), $getAction('delete'), $getAction('edit'), $getAction('reorder'), $getAction('indent'), $getAction('dedent')];
    @endphp

    <div wire:key="tree-items-wrapper">
        <div
            data-sortable-container
            ax-load
            ax-load-css="{{ \Filament\Support\Facades\FilamentAsset::getStyleHref('filament-adjacency-list-styles', 'saade/filament-adjacency-list') }}"
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-adjacency-list', 'saade/filament-adjacency-list') }}"
            x-data="tree({
                treeId: @js($treeId),
                statePath: @js($getStatePath()),
                disabled: @js($isDisabled),
                maxDepth: @js($maxDepth)
            })"
        >
            @forelse($getState() as $uuid => $item)
                <x-filament-adjacency-list::item
                    :uuid="$uuid"
                    :tree-id="$treeId"
                    :actions="$itemActions"
                    :addable="$isAddable"
                    :children-key="$getChildrenKey()"
                    :dedentable="$isIndentable && false"
                    :deletable="$isDeletable"
                    :disabled="$isDisabled"
                    :editable="$isEditable"
                    :indentable="$isIndentable && (!$loop->first && $loop->count > 1)"
                    :has-rulers="$hasRulers"
                    :is-collapsed="$isCollapsed"
                    :is-collapsible="$isCollapsible"
                    :is-indentable="$isIndentable"
                    :item="$item"
                    :item-state-path="$getStatePath() . '.' . $uuid"
                    :label-key="$getLabelKey()"
                    :reorderable="$isReorderable"
                    :state-path="$getStatePath()"
                    :max-depth="$maxDepth"
                />
            @empty
                <div @class([
                    'w-full bg-white rounded-lg border border-gray-300 px-3 py-2 text-left rtl:text-right',
                    'dark:bg-gray-900 dark:border-white/10',
                ])>
                    {{ __('filament-adjacency-list::adjacency-list.items.empty') }}
                </div>
            @endforelse
        </div>
    </div>

    <div class="flex justify-end">
        @if ($isAddable)
            {{ $addAction(['statePath' => $getStatePath()]) }}
        @endif
    </div>
</x-filament-forms::field-wrapper>
