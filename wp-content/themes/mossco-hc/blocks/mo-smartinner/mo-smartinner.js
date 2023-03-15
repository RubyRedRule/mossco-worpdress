
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
    
    const block = registerBlockType( 'mossco-hc/mo-smartinner', {
        apiVersion: 2,
        title: 'Mossco Smart Inner Block',
        description: '',
        icon: 'block-default',
        category: 'mo_blocks',
        parent: [ 'mossco-hc/mo-smartblock' ],

        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            inner_menu_link: {
                type: 'object',
                default: {post_id: 0, url: 'cafe-menu.html', title: '', 'post_type': null},
            },
            inner_menu_hover: {
                type: 'text',
                default: null,
            },
            inner_menu_bg: {
                type: 'object',
                default: {id: 0, url: '', size: '', svg: '', alt: null},
            },
            inner_menu_name: {
                type: 'text',
                default: `Café Menu`,
            }
        },
        example: { attributes: { inner_menu_link: {post_id: 0, url: 'cafe-menu.html', title: '', 'post_type': null}, inner_menu_hover: null, inner_menu_bg: {id: 0, url: '', size: '', svg: '', alt: null}, inner_menu_name: `Café Menu` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ href: propOrDefault( props.attributes.inner_menu_link.url, 'inner_menu_link', 'url' ), onClick: function(e) { e.preventDefault(); }, title: 'Click here to view our ' + props.attributes.inner_menu_name });
            const setAttributes = props.setAttributes; 
            
            props.inner_menu_bg = useSelect(function( select ) {
                return {
                    inner_menu_bg: props.attributes.inner_menu_bg.id ? select('core').getMedia(props.attributes.inner_menu_bg.id) : undefined
                };
            }, [props.attributes.inner_menu_bg] ).inner_menu_bg;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('a', { ...blockProps }, el('div', { className: 'flex h-56 items-center justify-center m-5 menu-box overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96' }, [' ', el('div', { className: 'absolute bg-center bg-cover bg-no-repeat bg-opacity-50 cafe-menu-img duration-500 ease-in-out h-full hover:bg-opacity-100 hover:scale-150 rounded-sm transform transition-all w-full', style: { backgroundImage: propOrDefault( props.attributes.inner_menu_bg.url, 'inner_menu_bg', 'url' ) ? ('url(' + propOrDefault( props.attributes.inner_menu_bg.url, 'inner_menu_bg', 'url' ) + ')') : null } }), ' ', el(RichText, { tagName: 'h2', className: 'absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all', value: propOrDefault( props.attributes.inner_menu_name, 'inner_menu_name' ), onChange: function(val) { setAttributes( {inner_menu_name: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' '])),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('inner_menu_bg', setAttributes, props, 'full', true, 'Menu Background Image', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    pgUrlControl('inner_menu_link', setAttributes, props, 'Menu Page Link', '', null ),
                                    el(TextControl, {
                                        value: props.attributes.inner_menu_name,
                                        help: __( '' ),
                                        label: __( 'Menu Name' ),
                                        onChange: function(val) { setAttributes({inner_menu_name: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ href: propOrDefault( props.attributes.inner_menu_link.url, 'inner_menu_link', 'url' ), onClick: function(e) { e.preventDefault(); }, title: 'Click here to view our ' + props.attributes.inner_menu_name });
            return el('a', { ...blockProps }, el('div', { className: 'flex h-56 items-center justify-center m-5 menu-box overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96' }, [' ', el('div', { className: 'absolute bg-center bg-cover bg-no-repeat bg-opacity-50 cafe-menu-img duration-500 ease-in-out h-full hover:bg-opacity-100 hover:scale-150 rounded-sm transform transition-all w-full', style: { backgroundImage: propOrDefault( props.attributes.inner_menu_bg.url, 'inner_menu_bg', 'url' ) ? ('url(' + propOrDefault( props.attributes.inner_menu_bg.url, 'inner_menu_bg', 'url' ) + ')') : null } }), ' ', el(RichText.Content, { tagName: 'h2', className: 'absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all', value: propOrDefault( props.attributes.inner_menu_name, 'inner_menu_name' ) }), ' ']));
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
