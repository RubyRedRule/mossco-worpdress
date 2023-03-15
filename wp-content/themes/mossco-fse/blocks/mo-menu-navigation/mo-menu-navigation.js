
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
    
    const block = registerBlockType( 'mossco-fse/mo-menu-navigation', {
        apiVersion: 2,
        title: 'Menu Pages Navigation',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm4.5-14.5L10 10l-2.5 6.5L14 14l2.5-6.5zM12 13a1 1 0 1 1 0-2 1 1 0 0 1 0 2z' })]),
        category: 'mo_menu_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_mossco_logo: {
                type: 'object',
                default: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/logo/logo-white-teal.svg', size: '', svg: '', alt: null},
            },
            mo_nav_button_link: {
                type: 'object',
                default: {post_id: 0, url: '#', title: '', 'post_type': null},
            },
            mo_nav_button_text: {
                type: 'text',
                default: `Book a Table`,
            }
        },
        example: { attributes: { mo_mossco_logo: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/logo/logo-white-teal.svg', size: '', svg: '', alt: null}, mo_nav_button_link: {post_id: 0, url: '#', title: '', 'post_type': null}, mo_nav_button_text: `Book a Table` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'h-24 sm:h-28 sticky top-0 z-50', 'data-pgc-define': 'mossco-navbar-menus', 'data-pgc-define-name': 'Mossco Navbar Menus', 'data-pgc-section': 'Mossco Headers and Footers', 'data-pg-ia-scene': '{"l":[{"name":"burger menu","t":"button","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0%"},{"name":"book table button tablet","t":"nav #gt# a:nth-of-type(2)","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]}}]}' });
            const setAttributes = props.setAttributes; 
            
            props.mo_mossco_logo = useSelect(function( select ) {
                return {
                    mo_mossco_logo: props.attributes.mo_mossco_logo.id ? select('core').getMedia(props.attributes.mo_mossco_logo.id) : undefined
                };
            }, [props.attributes.mo_mossco_logo] ).mo_mossco_logo;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                
                        el( ServerSideRender, {
                            block: 'mossco-fse/mo-menu-navigation',
                            httpMethod: 'POST',
                            attributes: props.attributes,
                            innerBlocksProps: innerBlocksProps,
                            blockProps: blockProps
                        } ),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('mo_mossco_logo', setAttributes, props, 'full', true, 'Mossco Logo Image', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    pgUrlControl('mo_nav_button_link', setAttributes, props, 'Desktop & Mobile Nav Button Link', '', null ),
                                    el(TextControl, {
                                        value: props.attributes.mo_nav_button_text,
                                        help: __( '' ),
                                        label: __( 'Desktop & Mobile Nav Button Text' ),
                                        onChange: function(val) { setAttributes({mo_nav_button_text: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            return null;
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
