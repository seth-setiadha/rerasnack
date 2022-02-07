<div x-data="{isTyped: false}">
    <div>
        <div class="relative">
            <input type="text"
                placeholder="{{__('Search ...')}}"
                x-on:input.debounce.400ms="isTyped = ($event.target.value != '')"
                autocomplete="off"
                wire:model.debounce.500ms="search"
                aria-label="Search input" />
        </div>
        {{-- search box --}}
        <div x-show="isTyped" x-cloak>
            <div>
                <div>
                    @forelse($items as $item)
                        <div>
                            <ul>
                                <li>
                                    <a href="#">
                                        {{$item->item_name}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @empty
                        <div x-cloak>
                            {{$isEmpty}}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

<!-- <div>
    <label for="validationCustom04" class="form-label">State</label>
    <input wire:model="searchItem" type="text" placeholder="Search items..."/>
    <select wire:model="searchItem" class="form-select" id="validationCustom04" required>
        <option selected disabled value="">Choose Item...</option>
        @foreach ($items as $item)
            <option>{{ $item->item_name }}</option>
        @endforeach
    </select>
</div> -->