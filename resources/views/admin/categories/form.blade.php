@if (!function_exists('renderCategories'))
    @php
        function renderCategories($categories, $selectedIds = [], $depth = 0) {
            foreach ($categories as $category) {
                echo '<option value="' . $category->id . '" ' . (in_array($category->id, (array) $selectedIds) ? 'selected' : '') . '>';
                echo str_repeat('&nbsp;&nbsp;&nbsp;', $depth) . $category->name;
                echo '</option>';

                if ($category->children->count() > 0) {
                    renderCategories($category->children, $selectedIds, $depth + 1);
                }
            }
        }
    @endphp
@endif
