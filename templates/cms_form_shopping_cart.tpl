<div class="table-nav sticky-header-container col-sm-10">
    <table class="table initialized" id="shopping_cart">
    <thead>
        <tr>
        {foreach $element['columns'] as $key=>$column}
            <th {if $column['width']} width="{$column['width']}{/if}" data-rowname="{$key}" class="shoppingCartRow">{$column}</th>
        {/foreach}
        </tr>
    </thead>
    </table>
</div>