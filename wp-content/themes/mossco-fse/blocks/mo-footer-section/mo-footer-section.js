
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
    
    const block = registerBlockType( 'mossco-fse/mo-footer-section', {
        apiVersion: 2,
        title: 'Mossco Footer Section',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M21 3a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h18zm-2 13H5v2h14v-2z' })]),
        category: 'mo_global_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_footer_logo_1: {
                type: 'object',
                default: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/logo/Mosso%20black%20white.svg', size: '', svg: '', alt: null},
            },
            mo_footer_logo_2: {
                type: 'object',
                default: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/logo/Travelodge%20black%20white.svg', size: '', svg: '', alt: null},
            },
            m_footer_copyright: {
                type: 'text',
                default: `Copyright &copy; 2023 Mossco`,
            }
        },
        example: { attributes: { mo_footer_logo_1: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/logo/Mosso%20black%20white.svg', size: '', svg: '', alt: null}, mo_footer_logo_2: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/logo/Travelodge%20black%20white.svg', size: '', svg: '', alt: null}, m_footer_copyright: `Copyright &copy; 2023 Mossco` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'bg-primary-NORMAL font-light py-12 text-gray-500', 'data-pg-ia-scene': '{"l":[{"name":"Mossco logo footer","t":".container #gt# div:nth-of-type(1) #gt# div:nth-of-type(1) #gt# img","a":"fadeInUp","p":"time","s":"20%"},{"t":".container #gt# div:nth-of-type(1) #gt# div:nth-of-type(2) #gt# img","p":"time","s":"30%","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]}}]}', 'data-pgc': 'mossco.footer', 'data-pgc-no-update': null });
            const setAttributes = props.setAttributes; 
            
            props.mo_footer_logo_1 = useSelect(function( select ) {
                return {
                    mo_footer_logo_1: props.attributes.mo_footer_logo_1.id ? select('core').getMedia(props.attributes.mo_footer_logo_1.id) : undefined
                };
            }, [props.attributes.mo_footer_logo_1] ).mo_footer_logo_1;
            

            props.mo_footer_logo_2 = useSelect(function( select ) {
                return {
                    mo_footer_logo_2: props.attributes.mo_footer_logo_2.id ? select('core').getMedia(props.attributes.mo_footer_logo_2.id) : undefined
                };
            }, [props.attributes.mo_footer_logo_2] ).mo_footer_logo_2;
            
            
            const innerBlocksProps = useInnerBlocksProps({ className: 'flex-wrap inline-flex justify-center justify-end justify-self-auto pb-4 pt-6 space-x-12 text-Mossco-grey-background w-full md:justify-end md:pb-0 md:space-x-6', style: { gridArea: '2 / 1 / 3 / 2' } }, {
                allowedBlocks: [ 'mossco-fse/mo-footer-social' ],
                template: [
    [ 'mossco-fse/mo-footer-social', {} ],
    [ 'mossco-fse/mo-footer-social', {} ],
    [ 'mossco-fse/mo-footer-social', {} ],
    [ 'mossco-fse/mo-footer-social', {} ]
],
            } );
                            
            
            return el(Fragment, {}, [
                
                        el( ServerSideRender, {
                            block: 'mossco-fse/mo-footer-section',
                            httpMethod: 'POST',
                            attributes: props.attributes,
                            innerBlocksProps: innerBlocksProps,
                            blockProps: blockProps
                        } ),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('mo_footer_logo_1', setAttributes, props, 'full', true, 'Footer Logo Left', '' ),
                                        
                        pgMediaImageControl('mo_footer_logo_2', setAttributes, props, 'full', true, 'Footer Logo Right', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.m_footer_copyright,
                                        help: __( '' ),
                                        label: __( 'm_footer_copyright' ),
                                        onChange: function(val) { setAttributes({m_footer_copyright: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

            save: function(props) {
                return el(InnerBlocks.Content);
            }                        
    
    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
