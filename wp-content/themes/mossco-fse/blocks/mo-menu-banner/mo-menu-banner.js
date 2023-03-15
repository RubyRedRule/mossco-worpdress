
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
    
    const block = registerBlockType( 'mossco-fse/mo-menu-banner', {
        apiVersion: 2,
        title: 'Menu Banner Block',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M5 11.1l2-2 5.5 5.5 3.5-3.5 3 3V5H5v6.1zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm11.5 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z' })]),
        category: 'mo_menu_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_menu_banner_img: {
                type: 'object',
                default: {id: 0, url: '', size: '', svg: '', alt: null},
            },
            mo_menu_banner_header: {
                type: 'text',
                default: `Café menu`,
            }
        },
        example: { attributes: { mo_menu_banner_img: {id: 0, url: '', size: '', svg: '', alt: null}, mo_menu_banner_header: `Café menu` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ 'data-pg-name': 'Menu Banner Section' });
            const setAttributes = props.setAttributes; 
            
            props.mo_menu_banner_img = useSelect(function( select ) {
                return {
                    mo_menu_banner_img: props.attributes.mo_menu_banner_img.id ? select('core').getMedia(props.attributes.mo_menu_banner_img.id) : undefined
                };
            }, [props.attributes.mo_menu_banner_img] ).mo_menu_banner_img;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { 'data-pg-ia-scene': '{"l":[{"name":"H1 Fadein UP","t":"h1","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"},{"name":"banner fade in","t":"#cafe-banner","p":"time","a":"fadeIn"}]}' }, [' ', el('section', { id: 'cafe-banner', className: '-mt-28 border-b-4 border-primary-NORMAL border-solid cafe-banner flex items-center justify-center', 'data-pg-ia-hide': '', style: { backgroundImage: propOrDefault( props.attributes.mo_menu_banner_img.url, 'mo_menu_banner_img', 'url' ) ? ('url(' + propOrDefault( props.attributes.mo_menu_banner_img.url, 'mo_menu_banner_img', 'url' ) + ')') : null } }, [' ', el('div', { className: 'flex justify-center text-center text-gray-200 w-full xl:place-self-center' }, [' ', el(RichText, { tagName: 'h1', className: 'flex font-medium font-sans lowercase text-5xl text-center translate-y-12 sm:text-6xl md:text-6xl lg:text-6xl xl:text-7xl 2xl:text-7xl', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_menu_banner_header, 'mo_menu_banner_header' ), onChange: function(val) { setAttributes( {mo_menu_banner_header: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('mo_menu_banner_img', setAttributes, props, 'full', true, 'Menu Banner Image', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.mo_menu_banner_header,
                                        help: __( '' ),
                                        label: __( 'Banner Heading' ),
                                        onChange: function(val) { setAttributes({mo_menu_banner_header: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ 'data-pg-name': 'Menu Banner Section' });
            return el('section', { ...blockProps }, [' ', el('div', { 'data-pg-ia-scene': '{"l":[{"name":"H1 Fadein UP","t":"h1","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"},{"name":"banner fade in","t":"#cafe-banner","p":"time","a":"fadeIn"}]}' }, [' ', el('section', { id: 'cafe-banner', className: '-mt-28 border-b-4 border-primary-NORMAL border-solid cafe-banner flex items-center justify-center', 'data-pg-ia-hide': '', style: { backgroundImage: propOrDefault( props.attributes.mo_menu_banner_img.url, 'mo_menu_banner_img', 'url' ) ? ('url(' + propOrDefault( props.attributes.mo_menu_banner_img.url, 'mo_menu_banner_img', 'url' ) + ')') : null } }, [' ', el('div', { className: 'flex justify-center text-center text-gray-200 w-full xl:place-self-center' }, [' ', el(RichText.Content, { tagName: 'h1', className: 'flex font-medium font-sans lowercase text-5xl text-center translate-y-12 sm:text-6xl md:text-6xl lg:text-6xl xl:text-7xl 2xl:text-7xl', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_menu_banner_header, 'mo_menu_banner_header' ) }), ' ']), ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
