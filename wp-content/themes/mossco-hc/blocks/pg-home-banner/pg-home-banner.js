
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
    
    const block = registerBlockType( 'mossco-hc/pg-home-banner', {
        apiVersion: 2,
        title: 'Mossco Home Banner',
        description: '',
        icon: 'block-default',
        category: 'mo_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            pg_bg_banner_img: {
                type: 'object',
                default: {id: 0, url: '', size: '', svg: '', alt: null},
            },
            pg_banner_h1: {
                type: 'text',
                default: `bar | kitchen | terrace`,
            },
            pg_banner_h2: {
                type: 'text',
                default: `FOOD &amp; DRINK WITH STYLE`,
            },
            pg_banner_btn_link: {
                type: 'object',
                default: {post_id: 0, url: '#home-menus', title: '', 'post_type': null},
            },
            pg_banner_btn_text: {
                type: 'text',
                default: `View Menus`,
            }
        },
        example: { attributes: { pg_bg_banner_img: {id: 0, url: '', size: '', svg: '', alt: null}, pg_banner_h1: `bar | kitchen | terrace`, pg_banner_h2: `FOOD &amp; DRINK WITH STYLE`, pg_banner_btn_link: {post_id: 0, url: '#home-menus', title: '', 'post_type': null}, pg_banner_btn_text: `View Menus` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: '-mt-28 border-b-4 border-primary-NORMAL border-solid hero-poster relative text-white', 'data-pg-name': 'Hero bg image', title: 'Hero bg image', 'data-pg-ia-scene': '{"smooth":"0.5","dbg":"true","l":[{"t":"h1","a":{"l":[{"t":"","l":[{"t":"set","p":1,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"0","rev":"true"},{"t":"h2","a":{"l":[{"t":"","l":[{"t":"set","p":1,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"0"},{"t":"a","a":{"l":[{"t":"","l":[{"t":"set","p":1.5,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.5,"d":0.5,"l":{"autoAlpha":1,"y":"10%"},"e":"Power1.easeOut"}]}]},"p":"time"}]}', style: { backgroundImage: propOrDefault( props.attributes.pg_bg_banner_img.url, 'pg_bg_banner_img', 'url' ) ? ('url(' + propOrDefault( props.attributes.pg_bg_banner_img.url, 'pg_bg_banner_img', 'url' ) + ')') : null } });
            const setAttributes = props.setAttributes; 
            
            props.pg_bg_banner_img = useSelect(function( select ) {
                return {
                    pg_bg_banner_img: props.attributes.pg_bg_banner_img.id ? select('core').getMedia(props.attributes.pg_bg_banner_img.id) : undefined
                };
            }, [props.attributes.pg_bg_banner_img] ).pg_bg_banner_img;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: 'flex mx-4' }, [' ', el('div', { className: 'hero-heading text-center w-full' }, [' ', el(RichText, { tagName: 'h1', className: 'Bauhaus bg-opacity-0 font-Bauhuas font-Heading font-Headings font-medium lowercase text-4xl sm:text-5xl md:text-6xl lg:text-6xl 2xl:text-7xl', 'data-pg-ia-hide': 'null', href: 'tailwind_theme/tailwind.css', value: propOrDefault( props.attributes.pg_banner_h1, 'pg_banner_h1' ), onChange: function(val) { setAttributes( {pg_banner_h1: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'h2', className: 'font-serif mt-4 pb-4 md:text-primary-NORMAL md:text-xl lg:text-2xl lg:text-primary-NORMAL 2xl:font-serif 2xl:leading-normal 2xl:text-3xl 2xl:text-primary-NORMAL', 'data-pg-ia-hide': 'null', value: propOrDefault( props.attributes.pg_banner_h2, 'pg_banner_h2' ), onChange: function(val) { setAttributes( {pg_banner_h2: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el('a', { href: propOrDefault( props.attributes.pg_banner_btn_link.url, 'pg_banner_btn_link', 'url' ), 'data-pg-ia-hide': '', onClick: function(e) { e.preventDefault(); } }, el(RichText, { tagName: 'button', className: 'active:bg-primary-DARK active:border-primary-DARK bg-opacity-20 bg-primary-LIGHT bg-primary_bg-NORMAL border-2 border-primary-NORMAL border-solid drop-shadow duration-300 ease-out hover:bg-primary-LIGHT hover:border-primary-LIGHT hover:drop-shadow-xl hover:ring hover:ring-primary-DARK hover:rounded-sm hover:text-white mt-5 px-8 py-2 rounded uppercase', value: propOrDefault( props.attributes.pg_banner_btn_text, 'pg_banner_btn_text' ), onChange: function(val) { setAttributes( {pg_banner_btn_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] })), ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('pg_bg_banner_img', setAttributes, props, 'full', true, 'Home Banner Image', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextareaControl, {
                                        value: props.attributes.pg_banner_h1,
                                        help: __( '' ),
                                        label: __( 'Home Banner H1' ),
                                        onChange: function(val) { setAttributes({pg_banner_h1: val}) },
                                    }),
                                    el(TextareaControl, {
                                        value: props.attributes.pg_banner_h2,
                                        help: __( '' ),
                                        label: __( 'Home Banner H2' ),
                                        onChange: function(val) { setAttributes({pg_banner_h2: val}) },
                                    }),
                                    pgUrlControl('pg_banner_btn_link', setAttributes, props, 'Home Banner Button Link', '', null ),
                                    el(TextareaControl, {
                                        value: props.attributes.pg_banner_btn_text,
                                        help: __( '' ),
                                        label: __( 'Home Banner Button Text' ),
                                        onChange: function(val) { setAttributes({pg_banner_btn_text: val}) },
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ className: '-mt-28 border-b-4 border-primary-NORMAL border-solid hero-poster relative text-white', 'data-pg-name': 'Hero bg image', title: 'Hero bg image', 'data-pg-ia-scene': '{"smooth":"0.5","dbg":"true","l":[{"t":"h1","a":{"l":[{"t":"","l":[{"t":"set","p":1,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"0","rev":"true"},{"t":"h2","a":{"l":[{"t":"","l":[{"t":"set","p":1,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"0"},{"t":"a","a":{"l":[{"t":"","l":[{"t":"set","p":1.5,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.5,"d":0.5,"l":{"autoAlpha":1,"y":"10%"},"e":"Power1.easeOut"}]}]},"p":"time"}]}', style: { backgroundImage: propOrDefault( props.attributes.pg_bg_banner_img.url, 'pg_bg_banner_img', 'url' ) ? ('url(' + propOrDefault( props.attributes.pg_bg_banner_img.url, 'pg_bg_banner_img', 'url' ) + ')') : null } });
            return el('section', { ...blockProps }, [' ', el('div', { className: 'flex mx-4' }, [' ', el('div', { className: 'hero-heading text-center w-full' }, [' ', el(RichText.Content, { tagName: 'h1', className: 'Bauhaus bg-opacity-0 font-Bauhuas font-Heading font-Headings font-medium lowercase text-4xl sm:text-5xl md:text-6xl lg:text-6xl 2xl:text-7xl', 'data-pg-ia-hide': 'null', href: 'tailwind_theme/tailwind.css', value: propOrDefault( props.attributes.pg_banner_h1, 'pg_banner_h1' ) }), ' ', el(RichText.Content, { tagName: 'h2', className: 'font-serif mt-4 pb-4 md:text-primary-NORMAL md:text-xl lg:text-2xl lg:text-primary-NORMAL 2xl:font-serif 2xl:leading-normal 2xl:text-3xl 2xl:text-primary-NORMAL', 'data-pg-ia-hide': 'null', value: propOrDefault( props.attributes.pg_banner_h2, 'pg_banner_h2' ) }), ' ', el('a', { href: propOrDefault( props.attributes.pg_banner_btn_link.url, 'pg_banner_btn_link', 'url' ), 'data-pg-ia-hide': '' }, el(RichText.Content, { tagName: 'button', className: 'active:bg-primary-DARK active:border-primary-DARK bg-opacity-20 bg-primary-LIGHT bg-primary_bg-NORMAL border-2 border-primary-NORMAL border-solid drop-shadow duration-300 ease-out hover:bg-primary-LIGHT hover:border-primary-LIGHT hover:drop-shadow-xl hover:ring hover:ring-primary-DARK hover:rounded-sm hover:text-white mt-5 px-8 py-2 rounded uppercase', value: propOrDefault( props.attributes.pg_banner_btn_text, 'pg_banner_btn_text' ) })), ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
