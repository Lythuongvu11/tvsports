<li>
    <input type="checkbox" class="category-checkbox" name="category_ids[]" value="{{ $category->id }}" @if($checked) checked @endif>
    {{ $category->name }}
    @if($category->children->count() > 0)
        <ul>
            @foreach($category->children as $childCategory)
                @include('admin.coupons.category-checkbox', [
                    'category' => $childCategory,
                    'checked' => $checked && in_array($childCategory->id, $selectedCategories),
                ])
            @endforeach
        </ul>
    @endif
</li>
