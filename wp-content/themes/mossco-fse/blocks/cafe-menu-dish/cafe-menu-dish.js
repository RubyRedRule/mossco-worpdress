
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
    
    const block = registerBlockType( 'mossco-fse/cafe-menu-dish', {
        apiVersion: 2,
        title: 'Menu Dish',
        description: '',
        icon: 'block-default',
        category: 'mo_menu_blocks',
        parent: [ 'mossco-fse/mo-cafe-menu' ],

        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            cafe_menu_dish_dd: {
                type: 'text',
                default: `Selection of Danish pastries, Croissants and Pain Chocolate`,
            },
            cafe_menu_dish_allerg: {
                type: 'text',
                default: `(1)`,
            },
            cafe_menu_dish_price: {
                type: 'text',
                default: `€ 3.50`,
            }
        },
        example: { attributes: { cafe_menu_dish_dd: `Selection of Danish pastries, Croissants and Pain Chocolate`, cafe_menu_dish_allerg: `(1)`, cafe_menu_dish_price: `€ 3.50` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'menu_item' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('div', { ...blockProps }, [' ', el(RichText, { tagName: 'dd', value: propOrDefault( props.attributes.cafe_menu_dish_dd, 'cafe_menu_dish_dd' ), onChange: function(val) { setAttributes( {cafe_menu_dish_dd: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'p', className: 'allergen_info', value: propOrDefault( props.attributes.cafe_menu_dish_allerg, 'cafe_menu_dish_allerg' ), onChange: function(val) { setAttributes( {cafe_menu_dish_allerg: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'p', className: 'price', value: propOrDefault( props.attributes.cafe_menu_dish_price, 'cafe_menu_dish_price' ), onChange: function(val) { setAttributes( {cafe_menu_dish_price: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_dish_dd,
                                        help: __( '' ),
                                        label: __( 'Dish Description' ),
                                        onChange: function(val) { setAttributes({cafe_menu_dish_dd: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_dish_allerg,
                                        help: __( '' ),
                                        label: __( 'Dish Allergens' ),
                                        onChange: function(val) { setAttributes({cafe_menu_dish_allerg: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_dish_price,
                                        help: __( '' ),
                                        label: __( 'Dish Price' ),
                                        onChange: function(val) { setAttributes({cafe_menu_dish_price: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ className: 'menu_item' });
            return el('div', { ...blockProps }, [' ', el(RichText.Content, { tagName: 'dd', value: propOrDefault( props.attributes.cafe_menu_dish_dd, 'cafe_menu_dish_dd' ) }), ' ', el(RichText.Content, { tagName: 'p', className: 'allergen_info', value: propOrDefault( props.attributes.cafe_menu_dish_allerg, 'cafe_menu_dish_allerg' ) }), ' ', el(RichText.Content, { tagName: 'p', className: 'price', value: propOrDefault( props.attributes.cafe_menu_dish_price, 'cafe_menu_dish_price' ) }), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
