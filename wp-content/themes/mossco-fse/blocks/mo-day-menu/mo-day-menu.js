
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
    
    const block = registerBlockType( 'mossco-fse/mo-day-menu', {
        apiVersion: 2,
        title: 'Day Menu Block',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M11 5H5v14h6V5zm2 0v14h6V5h-6zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z' })]),
        category: 'mo_menu_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            day_menu_left_col: {
                type: 'text',
                default: `<h3 class="border-b-2 border-primary-NORMAL border-solid mb-6 mt-2 pb-10 text-3xl text-primary-NORMAL md:mb-6">Terrance Bites</h3> <div class="menu_item"> <dt>Mossco Sharing Platter</dt> <dd>Crispy chicken wings, woodfired garlic & oregano flatbread, honey & soya pork ribs, & black tiger prawn skewers
</dd> <p class="allergen_info">(1,2,7,9,10,11)</p> <p class="italic mb-7 mt-2 text-primary-LIGHT">We recommend pairing this with Hope Beer Seasonal draft</p> </div> <div class="menu_item"> <dt>Award Winning Irish Cheeses & Charcuterie Platter</dt> <dd>Served with a selection of cracker, quince jelly & grapes Gubeen salami, Gubeen chorizo</dd> <p class="allergen_info">(1,7)</p> <p class="italic mb-7 mt-2 text-primary-LIGHT">We recommend pairing this with Hope Beer Hop-on Session IPA</p> </div> <div class="menu_item"> <dt>Crispy Chicken Wings</dt> <dd>Cashel blue cheese dip, Frank's hot sauce</dd> <p class="allergen_info">(1, 7, 9, 10)</p> <!-- <p class="price">€10.00</p> --> </div> <div class="menu_item"> <dt>Humus Starter</dt> <dd>Humus, carrots, cucumber, black olives, oregano flatbread</dd> <p class="allergen_info">(1)</p> <!-- <p class="price">€5.50</p> --> </div>`,
            },
            day_menu_right_col: {
                type: 'text',
                default: `<h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Mossco Pizza</h4> <div class="border-primary-NORMAL border-r-4 border-t-4 dark part2 pb-16 lg:pb-0 xl:pb-14 2xl:pb-12 rounded-xl md:my-0"> <div class="menu_item"> <dt class="mt-6">Margherita</dt> <dd>Toonsbridge buffalo mozzarella, basil, parmesan, tomato sauce & olive oil</dd> <p class="allergen_info pb-7">(1,7,9)</p> <!-- <p class="price">€3.00</p> --> </div> <div class="menu_item"> <dt>Crunchy peanut butter &amp; banoffee toffee</dt> <dd>Vanilla ice cream, peanut butter &amp; toffee sauce, banana &amp; crus</dd> <p class="allergen_info">(10,4)</p> <p class="price">€2.50</p> </div> </div> <div data-empty-placeholder class="2xl:pt-32 day-menu-bg h-0 hidden lg:pb-40 md:flex md:pb-52 pt-48 xl:pt-36"></div>`,
            }
        },
        example: { attributes: { day_menu_left_col: `<h3 class="border-b-2 border-primary-NORMAL border-solid mb-6 mt-2 pb-10 text-3xl text-primary-NORMAL md:mb-6">Terrance Bites</h3> <div class="menu_item"> <dt>Mossco Sharing Platter</dt> <dd>Crispy chicken wings, woodfired garlic & oregano flatbread, honey & soya pork ribs, & black tiger prawn skewers
</dd> <p class="allergen_info">(1,2,7,9,10,11)</p> <p class="italic mb-7 mt-2 text-primary-LIGHT">We recommend pairing this with Hope Beer Seasonal draft</p> </div> <div class="menu_item"> <dt>Award Winning Irish Cheeses & Charcuterie Platter</dt> <dd>Served with a selection of cracker, quince jelly & grapes Gubeen salami, Gubeen chorizo</dd> <p class="allergen_info">(1,7)</p> <p class="italic mb-7 mt-2 text-primary-LIGHT">We recommend pairing this with Hope Beer Hop-on Session IPA</p> </div> <div class="menu_item"> <dt>Crispy Chicken Wings</dt> <dd>Cashel blue cheese dip, Frank's hot sauce</dd> <p class="allergen_info">(1, 7, 9, 10)</p> <!-- <p class="price">€10.00</p> --> </div> <div class="menu_item"> <dt>Humus Starter</dt> <dd>Humus, carrots, cucumber, black olives, oregano flatbread</dd> <p class="allergen_info">(1)</p> <!-- <p class="price">€5.50</p> --> </div>`, day_menu_right_col: `<h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Mossco Pizza</h4> <div class="border-primary-NORMAL border-r-4 border-t-4 dark part2 pb-16 lg:pb-0 xl:pb-14 2xl:pb-12 rounded-xl md:my-0"> <div class="menu_item"> <dt class="mt-6">Margherita</dt> <dd>Toonsbridge buffalo mozzarella, basil, parmesan, tomato sauce & olive oil</dd> <p class="allergen_info pb-7">(1,7,9)</p> <!-- <p class="price">€3.00</p> --> </div> <div class="menu_item"> <dt>Crunchy peanut butter &amp; banoffee toffee</dt> <dd>Vanilla ice cream, peanut butter &amp; toffee sauce, banana &amp; crus</dd> <p class="allergen_info">(10,4)</p> <p class="price">€2.50</p> </div> </div> <div data-empty-placeholder class="2xl:pt-32 day-menu-bg h-0 hidden lg:pb-40 md:flex md:pb-52 pt-48 xl:pt-36"></div>` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ id: 'mossco-menu-col', className: 'container flex flex-wrap font-sans max-w-screen-xl mx-auto px-4 py-14' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: 'gap-2 grid grid-cols-1 md:gap-10 md:grid-cols-2' }, [' ', el(RichText, { tagName: 'div', className: 'col-span-1', 'data-pg-name': 'Menu col 1', value: propOrDefault( props.attributes.day_menu_left_col, 'day_menu_left_col' ), onChange: function(val) { setAttributes( {day_menu_left_col: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'div', className: 'col-span-1 mt-5', 'data-pg-name': 'Menu col 2', value: propOrDefault( props.attributes.day_menu_right_col, 'day_menu_right_col' ), onChange: function(val) { setAttributes( {day_menu_right_col: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.day_menu_left_col,
                                        help: __( '' ),
                                        label: __( 'Left Menu Column' ),
                                        onChange: function(val) { setAttributes({day_menu_left_col: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.day_menu_right_col,
                                        help: __( '' ),
                                        label: __( 'Right Menu Column' ),
                                        onChange: function(val) { setAttributes({day_menu_right_col: val}) },
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
            return el('section', { ...blockProps }, [' ', el('div', { className: 'gap-2 grid grid-cols-1 md:gap-10 md:grid-cols-2' }, [' ', el(RichText.Content, { tagName: 'div', className: 'col-span-1', 'data-pg-name': 'Menu col 1', value: propOrDefault( props.attributes.day_menu_left_col, 'day_menu_left_col' ) }), ' ', el(RichText.Content, { tagName: 'div', className: 'col-span-1 mt-5', 'data-pg-name': 'Menu col 2', value: propOrDefault( props.attributes.day_menu_right_col, 'day_menu_right_col' ) }), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
