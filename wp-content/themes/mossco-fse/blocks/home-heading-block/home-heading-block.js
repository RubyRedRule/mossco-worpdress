
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
    
    const block = registerBlockType( 'mossco-fse/home-heading-block', {
        apiVersion: 2,
        title: 'Home banner block',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M19 12H5v7h14v-7zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z' })]),
        category: 'mo_home_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_home_bg_img: {
                type: 'object',
                default: {id: 0, url: '', size: '', svg: '', alt: null},
            },
            mo_home_h1: {
                type: 'text',
                default: `bar | kitchen | terrace`,
            },
            mo_home_heading_h2: {
                type: 'text',
                default: `FOOD &amp; DRINK WITH STYLE`,
            },
            mo_banner_btn_text: {
                type: 'text',
                default: `View Menus`,
            },
            mo_banner_btn_bg: {
                type: 'text',
                default: '',
            },
            mo_banner_btn_br: {
                type: 'text',
                default: '',
            }
        },
        example: { attributes: { mo_home_bg_img: {id: 0, url: '', size: '', svg: '', alt: null}, mo_home_h1: `bar | kitchen | terrace`, mo_home_heading_h2: `FOOD &amp; DRINK WITH STYLE`, mo_banner_btn_text: `View Menus`, mo_banner_btn_bg: '', mo_banner_btn_br: '' } },
        edit: function ( props ) {
            const blockProps = useBlockProps({});
            const setAttributes = props.setAttributes; 
            
            props.mo_home_bg_img = useSelect(function( select ) {
                return {
                    mo_home_bg_img: props.attributes.mo_home_bg_img.id ? select('core').getMedia(props.attributes.mo_home_bg_img.id) : undefined
                };
            }, [props.attributes.mo_home_bg_img] ).mo_home_bg_img;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: '-mt-28 border-b-4 border-primary-NORMAL border-solid flex flex-col hero-poster place-content-center place-items-center relative text-white', 'data-pg-ia-scene': '{"l":[{"name":"h1","t":"h1","a":{"l":[{"t":"","l":[{"t":"set","p":1.2,"d":0,"l":{"autoAlpha":1,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.2,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"},{"name":"h2","t":"h2","a":{"l":[{"t":"","l":[{"t":"set","p":1.2,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.2,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"},{"name":"Button","t":"button","a":{"l":[{"t":"","l":[{"t":"set","p":1.4,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.4,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"},{"name":"bg image","t":"this","a":"fadeIn","p":"time"}]}', 'data-pg-ia-hide': '', style: { backgroundImage: propOrDefault( props.attributes.mo_home_bg_img.url, 'mo_home_bg_img', 'url' ) ? ('url(' + propOrDefault( props.attributes.mo_home_bg_img.url, 'mo_home_bg_img', 'url' ) + ')') : null } }, [' ', el('div', { className: 'flex flex-col hero-heading items-center mx-auto' }, [' ', el(RichText, { tagName: 'h1', className: 'font-sans bg-opacity-0 font-Bauhuas font-Heading font-medium lowercase text-4xl sm:text-5xl md:text-6xl lg:text-6xl 2xl:text-7xl', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_home_h1, 'mo_home_h1' ), onChange: function(val) { setAttributes( {mo_home_h1: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'h2', className: 'font-serif mt-4 pb-4 md:text-primary-NORMAL md:text-xl lg:text-2xl lg:text-primary-NORMAL 2xl:font-serif 2xl:leading-normal 2xl:text-3xl 2xl:text-primary-NORMAL', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_home_heading_h2, 'mo_home_heading_h2' ), onChange: function(val) { setAttributes( {mo_home_heading_h2: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'button', className: 'active:bg-primary-DARK active:border-primary-DARK bg-opacity-20 bg-primary-LIGHT bg-primary_bg-NORMAL border-2 border-primary-NORMAL border-solid drop-shadow duration-300 ease-out font-sans hover:bg-primary-LIGHT hover:border-primary-LIGHT hover:drop-shadow-xl hover:ring hover:ring-primary-DARK hover:rounded-sm hover:text-white mt-5 px-8 py-2 rounded uppercase', 'data-pg-ia-hide': '', style: { backgroundColor: propOrDefault( props.attributes.mo_banner_btn_bg, 'mo_banner_btn_bg' ),borderColor: propOrDefault( props.attributes.mo_banner_btn_br, 'mo_banner_btn_br' ) }, value: propOrDefault( props.attributes.mo_banner_btn_text, 'mo_banner_btn_text' ), onChange: function(val) { setAttributes( {mo_banner_btn_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('mo_home_bg_img', setAttributes, props, 'full', true, 'Banner Background image', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.mo_home_h1,
                                        help: __( '' ),
                                        label: __( 'Heading Text' ),
                                        onChange: function(val) { setAttributes({mo_home_h1: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_home_heading_h2,
                                        help: __( '' ),
                                        label: __( 'Sub Heading Text' ),
                                        onChange: function(val) { setAttributes({mo_home_heading_h2: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_banner_btn_text,
                                        help: __( '' ),
                                        label: __( 'Button Text' ),
                                        onChange: function(val) { setAttributes({mo_banner_btn_text: val}) },
                                        type: 'text'
                                    }),
                                    pgColorControl('mo_banner_btn_bg', setAttributes, props, 'Button Background Colour', ''),

                                    pgColorControl('mo_banner_btn_br', setAttributes, props, 'Button Border Colour', ''),
    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({});
            return el('section', { ...blockProps }, [' ', el('div', { className: '-mt-28 border-b-4 border-primary-NORMAL border-solid flex flex-col hero-poster place-content-center place-items-center relative text-white', 'data-pg-ia-scene': '{"l":[{"name":"h1","t":"h1","a":{"l":[{"t":"","l":[{"t":"set","p":1.2,"d":0,"l":{"autoAlpha":1,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.2,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"},{"name":"h2","t":"h2","a":{"l":[{"t":"","l":[{"t":"set","p":1.2,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.2,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"},{"name":"Button","t":"button","a":{"l":[{"t":"","l":[{"t":"set","p":1.4,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.4,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"},{"name":"bg image","t":"this","a":"fadeIn","p":"time"}]}', 'data-pg-ia-hide': '', style: { backgroundImage: propOrDefault( props.attributes.mo_home_bg_img.url, 'mo_home_bg_img', 'url' ) ? ('url(' + propOrDefault( props.attributes.mo_home_bg_img.url, 'mo_home_bg_img', 'url' ) + ')') : null } }, [' ', el('div', { className: 'flex flex-col hero-heading items-center mx-auto' }, [' ', el(RichText.Content, { tagName: 'h1', className: 'font-sans bg-opacity-0 font-Bauhuas font-Heading font-medium lowercase text-4xl sm:text-5xl md:text-6xl lg:text-6xl 2xl:text-7xl', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_home_h1, 'mo_home_h1' ) }), ' ', el(RichText.Content, { tagName: 'h2', className: 'font-serif mt-4 pb-4 md:text-primary-NORMAL md:text-xl lg:text-2xl lg:text-primary-NORMAL 2xl:font-serif 2xl:leading-normal 2xl:text-3xl 2xl:text-primary-NORMAL', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_home_heading_h2, 'mo_home_heading_h2' ) }), ' ', el(RichText.Content, { tagName: 'button', className: 'active:bg-primary-DARK active:border-primary-DARK bg-opacity-20 bg-primary-LIGHT bg-primary_bg-NORMAL border-2 border-primary-NORMAL border-solid drop-shadow duration-300 ease-out font-sans hover:bg-primary-LIGHT hover:border-primary-LIGHT hover:drop-shadow-xl hover:ring hover:ring-primary-DARK hover:rounded-sm hover:text-white mt-5 px-8 py-2 rounded uppercase', 'data-pg-ia-hide': '', style: { backgroundColor: propOrDefault( props.attributes.mo_banner_btn_bg, 'mo_banner_btn_bg' ),borderColor: propOrDefault( props.attributes.mo_banner_btn_br, 'mo_banner_btn_br' ) }, value: propOrDefault( props.attributes.mo_banner_btn_text, 'mo_banner_btn_text' ) }), ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
