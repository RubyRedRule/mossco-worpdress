
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
    
    const block = registerBlockType( 'mossco-fse/mo-nav-links', {
        apiVersion: 2,
        title: 'Mossco Navigation Links',
        description: '',
        icon: 'block-default',
        category: 'text',
        parent: [ 'mossco-fse/mo-home-header' ],

        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            inner_nav_item_link: {
                type: 'object',
                default: {post_id: 0, url: '#home-our-brand', title: '', 'post_type': null},
            },
            inner_nav_item_text: {
                type: 'text',
                default: `Our Story`,
            }
        },
        example: { attributes: { inner_nav_item_link: {post_id: 0, url: '#home-our-brand', title: '', 'post_type': null}, inner_nav_item_text: `Our Story` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'flex lg:border-primary-NORMAL lg:h-full lg:hover:border-b-2 lg:hover:border-primary-NORMAL lg:hover:border-solid', 'data-pg-id': '7344' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('li', { ...blockProps }, [' ', el(RichText, { tagName: 'a', href: propOrDefault( props.attributes.inner_nav_item_link.url, 'inner_nav_item_link', 'url' ), className: 'font-sans hover:text-primary-LIGHT px-0 py-2 scroll-smooth smooth-scrolling uppercase lg:px-4', onClick: function(e) { e.preventDefault(); }, value: propOrDefault( props.attributes.inner_nav_item_text, 'inner_nav_item_text' ), onChange: function(val) { setAttributes( {inner_nav_item_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    pgUrlControl('inner_nav_item_link', setAttributes, props, 'inner_nav_item_link', '', null ),
                                    el(TextControl, {
                                        value: props.attributes.inner_nav_item_text,
                                        help: __( '' ),
                                        label: __( 'inner_nav_item_text' ),
                                        onChange: function(val) { setAttributes({inner_nav_item_text: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ className: 'flex lg:border-primary-NORMAL lg:h-full lg:hover:border-b-2 lg:hover:border-primary-NORMAL lg:hover:border-solid', 'data-pg-id': '7344' });
            return el('li', { ...blockProps }, [' ', el(RichText.Content, { tagName: 'a', href: propOrDefault( props.attributes.inner_nav_item_link.url, 'inner_nav_item_link', 'url' ), className: 'font-sans hover:text-primary-LIGHT px-0 py-2 scroll-smooth smooth-scrolling uppercase lg:px-4', value: propOrDefault( props.attributes.inner_nav_item_text, 'inner_nav_item_text' ) }), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
