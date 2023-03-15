
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
    
    const block = registerBlockType( 'mossco-fse/cafe-menu-right-col', {
        apiVersion: 2,
        title: 'cafe-menu-right-col',
        description: '',
        icon: 'block-default',
        category: 'text',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            cafe_menu_right_col: {
                type: 'text',
                default: `<h4 class="border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase md:mt-0">Sweet pastries and cakes</h4> <p class="caption pb-12 pt-6">Selection of the items noted below available daily from 10am serviced from the bar. <br>Take out or eat in.</p> <div class="border-r-4 border-t-4 dark border-primary-NORMAL rounded-xl"> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Morning</h4> <div class="menu_item"> <dd>Selection of Danish pastries, Croissants and Pain Chocolate</dd> <p class="allergen_info">(1)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Fresh Scones</dd> <p class="allergen_info">(10,4)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Portuguese custard tarts</dd> <p class="allergen_info">(4)</p> <p class="price">€ 3.50</p> </div> </div> <div class="border-r-4 border-t-4 dark rounded-xl border-primary-NORMAL second mt-10"> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Afternoon</h4> <div class="menu_item"> <dd>Carrot cake</dd> <p class="allergen_info">(2,6)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Madeira sponge</dd> <p class="allergen_info">(11,14)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Brownies &amp; blondies</dd> <p class="allergen_info">(2)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Orange polenta cake</dd> <p class="allergen_info">(14)</p> <p class="price">€ 3.50</p> </div> </div> <div data-empty-placeholder class="cafe-menu-bg h-0"></div>`,
            }
        },
        example: { attributes: { cafe_menu_right_col: `<h4 class="border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase md:mt-0">Sweet pastries and cakes</h4> <p class="caption pb-12 pt-6">Selection of the items noted below available daily from 10am serviced from the bar. <br>Take out or eat in.</p> <div class="border-r-4 border-t-4 dark border-primary-NORMAL rounded-xl"> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Morning</h4> <div class="menu_item"> <dd>Selection of Danish pastries, Croissants and Pain Chocolate</dd> <p class="allergen_info">(1)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Fresh Scones</dd> <p class="allergen_info">(10,4)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Portuguese custard tarts</dd> <p class="allergen_info">(4)</p> <p class="price">€ 3.50</p> </div> </div> <div class="border-r-4 border-t-4 dark rounded-xl border-primary-NORMAL second mt-10"> <h4 class="border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase">Afternoon</h4> <div class="menu_item"> <dd>Carrot cake</dd> <p class="allergen_info">(2,6)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Madeira sponge</dd> <p class="allergen_info">(11,14)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Brownies &amp; blondies</dd> <p class="allergen_info">(2)</p> <p class="price">€ 3.50</p> </div> <div class="menu_item"> <dd>Orange polenta cake</dd> <p class="allergen_info">(14)</p> <p class="price">€ 3.50</p> </div> </div> <div data-empty-placeholder class="cafe-menu-bg h-0"></div>` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'col-span-1 md:mt-9 lg:mt-9', 'data-pg-name': 'Menu col 2' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('div', { ...blockProps }, [' ', el(RichText, { tagName: 'div', value: propOrDefault( props.attributes.cafe_menu_right_col, 'cafe_menu_right_col' ), onChange: function(val) { setAttributes( {cafe_menu_right_col: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_right_col,
                                        help: __( '' ),
                                        label: __( 'Column Right' ),
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
            const blockProps = useBlockProps.save({ className: 'col-span-1 md:mt-9 lg:mt-9', 'data-pg-name': 'Menu col 2' });
            return el('div', { ...blockProps }, [' ', el(RichText.Content, { tagName: 'div', value: propOrDefault( props.attributes.cafe_menu_right_col, 'cafe_menu_right_col' ) }), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
