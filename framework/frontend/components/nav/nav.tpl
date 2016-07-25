{**
 * Навигация
 *
 * @param string  $hook
 * @param array   $items
 * @param string  $activeItem
 * @param integer $hookParams
 * @param boolean $showSingle
 * @param boolean $isSubnav
 * @param string  $mods
 * @param string  $classes
 * @param array   $attributes
 *}

{* Название компонента *}
{$component = 'ls-nav'}
{component_define_params params=[ 'hook', 'items', 'activeItem', 'showSingle', 'isSubnav', 'items', 'mods', 'classes', 'attributes' ]}

{* Получаем пункты установленные плагинами *}
{if $hook}
    {hook run=$hook assign='hookItems' params=$smarty.local.params items=$items array=true}
    {$items = ( $hookItems ) ? $hookItems : $items}
{/if}

{* Считаем кол-во неактивных пунктов *}
{$disabledItemsCounter = 0}

{foreach $items as $item}
    {$disabledItemsCounter = $disabledItemsCounter + ( ! $item['is_enabled']|default:true && $item['name'] != '-' )}
{/foreach}

{$classes = "{$classes} ls-clearfix"}

{if $isSubnav}
    {$mods = "$mods sub"}
{/if}

{* Smarty-блок для изменения опций *}
{block 'nav_options'}{/block}

{* Отображем меню только если есть активные пункты *}
{if count( $items ) - $disabledItemsCounter - ( ( $showSingle|default:false ) ? 0 : 1 )}
    <ul class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
        {foreach $items as $item}
            {$isEnabled = $item[ 'is_enabled' ]}

            {if $item['html']}
                {$item['html']}
            {else}
                {if $isEnabled|default:true}
                    {if $item['name'] != '-'}
                        {component 'nav' template='item'
                            isRoot   = !$isSubnav
                            isActive = ($activeItem && $activeItem == $item['name'])
                            params   = $item}
                    {else}
                        {* Разделитель *}
                        <li class="{$component}-separator"></li>
                    {/if}
                {/if}
            {/if}
        {/foreach}
    </ul>
{/if}
