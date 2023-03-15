
( function ( blocks, element, blockEditor ) {
    const el = element.createElement,
        registerBlockType = blocks.registerBlockType,
        ServerSideRender = PgServerSideRender,
        InspectorControls = blockEditor.InspectorControls,
        useBlockProps = blockEditor.useBlockProps;
        
    const {__} = wp.i18n;
    const {ColorPicker, TextControl, ToggleControl, SelectControl, Panel, PanelBody, Disabled, TextareaControl, BaseControl} = wp.components;
    const {useSelect} = wp.data;
    const {RawHTML, Fragment} = element;
   
    const {InnerBlocks, URLInputButton, RichText} = wp.blockEditor;
    const useInnerBlocksProps = blockEditor.useInnerBlocksProps || blockEditor.__experimentalUseInnerBlocksProps;
    
    const propOrDefault = function(val, prop, field) {
        if(block.attributes[prop] && (val === null || val === '')) {
            return field ? block.attributes[prop].default[field] : block.attributes[prop].default;
        }
        return val;
    }
    
    const block = registerBlockType( 'mossco-fse/mo-cafe-menu', {
        apiVersion: 2,
        title: 'Cafe Menu Block',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M11 5H5v14h6V5zm2 0v14h6V5h-6zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z' })]),
        category: 'mo_menu_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            cafe_menu_left_col: {
                type: 'text',
                default: `<h3 class="font-sans text-3xl text-primary-NORMAL uppercase">Café</h3> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase">Sandwiches</h4> <p class="caption pb-8 pt-6 text-mossco_faint_teal-faintteal">Pre-made, cut and deli wrapped, available hot or cold. Served with daily soup, available from 12noon. <br>Take out or eat in.</p> <div class="menu_item"> <dt>Chargrilled chicken</dt> <dd>Slow roast tomatoes, rocket &amp; basil aioli on ciabatta</dd> <p class="allergen_info">(2,10,11,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Buffalo mozzarella</dt> <dd>Beef tomato, red onion, with basil pesto olive oil &amp; black pepper on ciabatta</dd> <p class="allergen_info">(1,2,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Honey glazed ham</dt> <dd>Smoked Hegarty’s cheddar, house slaw, rocket, onion, mustard mayo &amp; Ballymaloe relish.</dd> <p class="allergen_info">(10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Reuben</dt> <dd>Pastrami, swiss cheese, sauerkraut, pickles &amp; Russian dressing</dd> <p class="allergen_info">(2,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Turkey Caesar club</dt> <dd>Sliced turkey, crispy bacon, sliced cheddar, tomato, egg &amp; baby gem with Caesar mayo</dd> <p class="allergen_info">(2,5,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Roast chicken</dt> <dd>Tandoori mayo, pickled red onions, shaved carrot, coriander &amp; baby gem on ciabatta.</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Warm, crispy bacon</dt> <dd>Brie, and red onion jam ciabatta (HOT)</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Buffalo mozzarella</dt> <dd>Roasted red peppers, artichokes, rocket &amp; basil tomato pesto aioli on ciabatta. (HOT)</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Ploughman’s honey glazed ham</dt> <dd>Hegarty’s cheddar, pickled red onion, slice apple, Branston pickle and watercress baguette. </dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Classic croque monsieur</dt> <dd>(HOT)</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Poached chicken</dt> <dd>Avocado, tomato, red onion &amp; rocket, citrus aioli on wholegrain</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Tuna &amp; avocado</dt> <dd>With pickled veg &amp; coriander wrap. Warm beetroot, spinach &amp; goats cheese ciabatta (HOT)</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div>`,
            },
            cafe_menu_right_col: {
                type: 'text',
                default: `<h4 class="border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase md:mt-0">Sweet pastries and cakes</h4> <p class="caption pb-12 pt-6">Selection of the items noted below available daily from 10am serviced from the bar. <br>Take out or eat in.</p> <div class="border-r-4 border-t-4 dark border-primary-NORMAL rounded-xl"> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Morning</h4> <div class="menu_item"> <dd>Selection of Danish pastries, Croissants and Pain Chocolate</dd> <p class="allergen_info">(1)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Fresh Scones</dd> <p class="allergen_info">(10,4)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Portuguese custard tarts</dd> <p class="allergen_info">(4)</p> <p class="price">€ 3.50</p> </div> </div> <div class="border-r-4 border-t-4 dark rounded-xl border-primary-NORMAL second mt-10"> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Afternoon</h4> <div class="menu_item"> <dd>Carrot cake</dd> <p class="allergen_info">(2,6)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Madeira sponge</dd> <p class="allergen_info">(11,14)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Brownies &amp; blondies</dd> <p class="allergen_info">(2)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Orange polenta cake</dd> <p class="allergen_info">(14)</p> <p class="price">€ 3.50</p> </div> </div> <div data-empty-placeholder class="cafe-menu-bg h-0 hidden md:flex md:h-1/3 lg:h-1/3 xl:h-1/3"></div>`,
            }
        },
        example: { attributes: { cafe_menu_left_col: `<h3 class="font-sans text-3xl text-primary-NORMAL uppercase">Café</h3> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase">Sandwiches</h4> <p class="caption pb-8 pt-6 text-mossco_faint_teal-faintteal">Pre-made, cut and deli wrapped, available hot or cold. Served with daily soup, available from 12noon. <br>Take out or eat in.</p> <div class="menu_item"> <dt>Chargrilled chicken</dt> <dd>Slow roast tomatoes, rocket &amp; basil aioli on ciabatta</dd> <p class="allergen_info">(2,10,11,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Buffalo mozzarella</dt> <dd>Beef tomato, red onion, with basil pesto olive oil &amp; black pepper on ciabatta</dd> <p class="allergen_info">(1,2,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Honey glazed ham</dt> <dd>Smoked Hegarty’s cheddar, house slaw, rocket, onion, mustard mayo &amp; Ballymaloe relish.</dd> <p class="allergen_info">(10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Reuben</dt> <dd>Pastrami, swiss cheese, sauerkraut, pickles &amp; Russian dressing</dd> <p class="allergen_info">(2,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Turkey Caesar club</dt> <dd>Sliced turkey, crispy bacon, sliced cheddar, tomato, egg &amp; baby gem with Caesar mayo</dd> <p class="allergen_info">(2,5,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Roast chicken</dt> <dd>Tandoori mayo, pickled red onions, shaved carrot, coriander &amp; baby gem on ciabatta.</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Warm, crispy bacon</dt> <dd>Brie, and red onion jam ciabatta (HOT)</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Buffalo mozzarella</dt> <dd>Roasted red peppers, artichokes, rocket &amp; basil tomato pesto aioli on ciabatta. (HOT)</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Ploughman’s honey glazed ham</dt> <dd>Hegarty’s cheddar, pickled red onion, slice apple, Branston pickle and watercress baguette. </dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Classic croque monsieur</dt> <dd>(HOT)</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Poached chicken</dt> <dd>Avocado, tomato, red onion &amp; rocket, citrus aioli on wholegrain</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div> <div class="menu_item"> <dt>Tuna &amp; avocado</dt> <dd>With pickled veg &amp; coriander wrap. Warm beetroot, spinach &amp; goats cheese ciabatta (HOT)</dd> <p class="allergen_info">(1,2,9,10,4)</p> <p class="price">€5.50</p> </div>`, cafe_menu_right_col: `<h4 class="border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase md:mt-0">Sweet pastries and cakes</h4> <p class="caption pb-12 pt-6">Selection of the items noted below available daily from 10am serviced from the bar. <br>Take out or eat in.</p> <div class="border-r-4 border-t-4 dark border-primary-NORMAL rounded-xl"> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Morning</h4> <div class="menu_item"> <dd>Selection of Danish pastries, Croissants and Pain Chocolate</dd> <p class="allergen_info">(1)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Fresh Scones</dd> <p class="allergen_info">(10,4)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Portuguese custard tarts</dd> <p class="allergen_info">(4)</p> <p class="price">€ 3.50</p> </div> </div> <div class="border-r-4 border-t-4 dark rounded-xl border-primary-NORMAL second mt-10"> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Afternoon</h4> <div class="menu_item"> <dd>Carrot cake</dd> <p class="allergen_info">(2,6)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Madeira sponge</dd> <p class="allergen_info">(11,14)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Brownies &amp; blondies</dd> <p class="allergen_info">(2)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Orange polenta cake</dd> <p class="allergen_info">(14)</p> <p class="price">€ 3.50</p> </div> </div> <div data-empty-placeholder class="cafe-menu-bg h-0 hidden md:flex md:h-1/3 lg:h-1/3 xl:h-1/3"></div>` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ id: 'mossco-menu-col', className: 'container flex flex-wrap font-sans max-w-screen-xl mx-auto px-4 py-14' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: 'gap-2 grid grid-cols-1 md:gap-10 md:grid-cols-2' }, [' ', el(RichText, { tagName: 'div', className: 'col-span-1 menu', 'data-pg-name': 'Menu col 1', value: propOrDefault( props.attributes.cafe_menu_left_col, 'cafe_menu_left_col' ), onChange: function(val) { setAttributes( {cafe_menu_left_col: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'div', className: 'col-span-1 md:mt-9 lg:mt-9', 'data-pg-name': 'Menu col 2', value: propOrDefault( props.attributes.cafe_menu_right_col, 'cafe_menu_right_col' ), onChange: function(val) { setAttributes( {cafe_menu_right_col: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_left_col,
                                        help: __( '' ),
                                        label: __( 'Left Menu Column' ),
                                        onChange: function(val) { setAttributes({cafe_menu_left_col: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_right_col,
                                        help: __( '' ),
                                        label: __( 'Right Menu Column' ),
                                        onChange: function(val) { setAttributes({cafe_menu_right_col: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ id: 'mossco-menu-col', className: 'container flex flex-wrap font-sans max-w-screen-xl mx-auto px-4 py-14' });
            return el('section', { ...blockProps }, [' ', el('div', { className: 'gap-2 grid grid-cols-1 md:gap-10 md:grid-cols-2' }, [' ', el(RichText.Content, { tagName: 'div', className: 'col-span-1 menu', 'data-pg-name': 'Menu col 1', value: propOrDefault( props.attributes.cafe_menu_left_col, 'cafe_menu_left_col' ) }), ' ', el(RichText.Content, { tagName: 'div', className: 'col-span-1 md:mt-9 lg:mt-9', 'data-pg-name': 'Menu col 2', value: propOrDefault( props.attributes.cafe_menu_right_col, 'cafe_menu_right_col' ) }), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
