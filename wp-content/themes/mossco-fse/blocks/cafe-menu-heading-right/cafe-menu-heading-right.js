
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
    
    const block = registerBlockType( 'mossco-fse/cafe-menu-heading-right', {
        apiVersion: 2,
        title: 'Right Menu Heading Section',
        description: '',
        icon: 'block-default',
        category: 'mo_menu_blocks',
        parent: [ 'mossco-fse/mo-cafe-menu' ],

        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            cafe_menu_h4: {
                type: 'text',
                default: `Sweet pastries and cakes`,
            },
            cafe_menu_exerpt: {
                type: 'text',
                default: `Selection of the items noted below available daily from 10am serviced from the bar. <br>Take out or eat in.`,
            }
        },
        example: { attributes: { cafe_menu_h4: `Sweet pastries and cakes`, cafe_menu_exerpt: `Selection of the items noted below available daily from 10am serviced from the bar. <br>Take out or eat in.` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'col-span-1 md:mt-9 lg:mt-9', 'data-pg-name': 'Menu col 2' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('div', { ...blockProps }, [' ', el('div', {}, [' ', el(RichText, { tagName: 'h4', className: 'border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase md:mt-0', value: propOrDefault( props.attributes.cafe_menu_h4, 'cafe_menu_h4' ), onChange: function(val) { setAttributes( {cafe_menu_h4: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'p', className: 'caption pb-12 pt-6', value: propOrDefault( props.attributes.cafe_menu_exerpt, 'cafe_menu_exerpt' ), onChange: function(val) { setAttributes( {cafe_menu_exerpt: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el('div', { className: 'border-r-4 border-t-4 dark border-primary-NORMAL rounded-xl' }, [' ', el(RichText, { tagName: 'h4', className: 'border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase', value: propOrDefault( props.attributes.cafe_menu_h4, 'cafe_menu_h4' ), onChange: function(val) { setAttributes( {cafe_menu_h4: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Fresh Scones'), ' ', el('p', { className: 'allergen_info' }, '(10,4)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Portuguese custard tarts'), ' ', el('p', { className: 'allergen_info' }, '(4)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ']), ' ', el('div', { className: 'border-r-4 border-t-4 dark rounded-xl border-primary-NORMAL second mt-10' }, [' ', el('h4', { className: 'border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase' }, 'Afternoon'), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Carrot cake'), ' ', el('p', { className: 'allergen_info' }, '(2,6)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Madeira sponge'), ' ', el('p', { className: 'allergen_info' }, '(11,14)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Brownies & blondies'), ' ', el('p', { className: 'allergen_info' }, '(2)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Orange polenta cake'), ' ', el('p', { className: 'allergen_info' }, '(14)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ']), ' ', el('div', { 'data-empty-placeholder': '', className: 'cafe-menu-bg h-0' }), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_h4,
                                        help: __( '' ),
                                        label: __( 'Menu Category Sub Title' ),
                                        onChange: function(val) { setAttributes({cafe_menu_h4: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_exerpt,
                                        help: __( '' ),
                                        label: __( 'Menu Exerpt' ),
                                        onChange: function(val) { setAttributes({cafe_menu_exerpt: val}) },
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
            return el('div', { ...blockProps }, [' ', el('div', {}, [' ', el(RichText.Content, { tagName: 'h4', className: 'border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase md:mt-0', value: propOrDefault( props.attributes.cafe_menu_h4, 'cafe_menu_h4' ) }), ' ', el(RichText.Content, { tagName: 'p', className: 'caption pb-12 pt-6', value: propOrDefault( props.attributes.cafe_menu_exerpt, 'cafe_menu_exerpt' ) }), ' ', el('div', { className: 'border-r-4 border-t-4 dark border-primary-NORMAL rounded-xl' }, [' ', el(RichText.Content, { tagName: 'h4', className: 'border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase', value: propOrDefault( props.attributes.cafe_menu_h4, 'cafe_menu_h4' ) }), ' ', ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Fresh Scones'), ' ', el('p', { className: 'allergen_info' }, '(10,4)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Portuguese custard tarts'), ' ', el('p', { className: 'allergen_info' }, '(4)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ']), ' ', el('div', { className: 'border-r-4 border-t-4 dark rounded-xl border-primary-NORMAL second mt-10' }, [' ', el('h4', { className: 'border-b-2 border-primary-NORMAL border-solid font-sans my-6 pb-3 text-Mossco-grey-semi text-xl uppercase' }, 'Afternoon'), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Carrot cake'), ' ', el('p', { className: 'allergen_info' }, '(2,6)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Madeira sponge'), ' ', el('p', { className: 'allergen_info' }, '(11,14)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Brownies & blondies'), ' ', el('p', { className: 'allergen_info' }, '(2)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dd', {}, 'Orange polenta cake'), ' ', el('p', { className: 'allergen_info' }, '(14)'), ' ', el('p', { className: 'price' }, '€ 3.50'), ' ']), ' ']), ' ', el('div', { 'data-empty-placeholder': '', className: 'cafe-menu-bg h-0' }), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
