
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
    
    const block = registerBlockType( 'mossco-fse/mo-menu-nav-links', {
        apiVersion: 2,
        title: 'Mossco Navigation Links',
        description: '',
        icon: 'block-default',
        category: 'text',
        parent: [ 'mossco-fse/mo-menu-header' ],

        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            inner_menu_nav_link: {
                type: 'object',
                default: {post_id: 0, url: '#home-menus', title: '', 'post_type': null},
            },
            inner_menu_nav_item_text: {
                type: 'text',
                default: `Day menu`,
            }
        },
        example: { attributes: { inner_menu_nav_link: {post_id: 0, url: '#home-menus', title: '', 'post_type': null}, inner_menu_nav_item_text: `Day menu` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'flex' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('li', { ...blockProps }, [el(RichText, { tagName: 'a', href: propOrDefault( props.attributes.inner_menu_nav_link.url, 'inner_menu_nav_link', 'url' ), className: 'hover:text-primary-LIGHT px-0 py-2 scroll-smooth uppercase lg:px-4', onClick: function(e) { e.preventDefault(); }, value: propOrDefault( props.attributes.inner_menu_nav_item_text, 'inner_menu_nav_item_text' ), onChange: function(val) { setAttributes( {inner_menu_nav_item_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    pgUrlControl('inner_menu_nav_link', setAttributes, props, 'inner_menu_nav_link', '', null ),
                                    el(TextControl, {
                                        value: props.attributes.inner_menu_nav_item_text,
                                        help: __( '' ),
                                        label: __( 'inner_menu_nav_item_text' ),
                                        onChange: function(val) { setAttributes({inner_menu_nav_item_text: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ className: 'flex' });
            return el('li', { ...blockProps }, [el(RichText.Content, { tagName: 'a', href: propOrDefault( props.attributes.inner_menu_nav_link.url, 'inner_menu_nav_link', 'url' ), className: 'hover:text-primary-LIGHT px-0 py-2 scroll-smooth uppercase lg:px-4', value: propOrDefault( props.attributes.inner_menu_nav_item_text, 'inner_menu_nav_item_text' ) }), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
