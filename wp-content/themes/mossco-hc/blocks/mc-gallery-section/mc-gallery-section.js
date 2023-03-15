
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
    
    const block = registerBlockType( 'mossco-hc/mc-gallery-section', {
        apiVersion: 2,
        title: 'Mossco Gallery Block',
        description: '',
        icon: 'block-default',
        category: 'text',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mc_gallery_heading: {
                type: 'text',
                default: `Gallery`,
            }
        },
        example: { attributes: { mc_gallery_heading: `Gallery` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ 'data-empty-placeholder': null, 'data-pg-name': 'Gallery Wrapper' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('div', { ...blockProps }, el('section', { id: 'home-gallery', 'data-pg-ia-scene': '{"l":[{"name":"MENUS Header","t":"h3","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%"},{"t":"#gt# div #gt# div:nth-of-type(2)","p":"time","s":"30%","rev":"true","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]}}]}', 'data-pgc': 'mossco-gallery', 'data-pgc-no-update': '' }, [' ', el('div', { className: 'container max-w-screen-xl mx-auto py-16 md:py-16' }, [' ', el(RichText, { tagName: 'h3', className: 'pb-8 text-3xl text-center text-primary-NORMAL uppercase md:pb-10 md:pb-6', 'data-pg-ia-hide': 'null', value: propOrDefault( props.attributes.mc_gallery_heading, 'mc_gallery_heading' ), onChange: function(val) { setAttributes( {mc_gallery_heading: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el('div', { className: 'mossco-gallery-grid' }, [' ', el('div', { className: 'gallery-item-1' }, [' ', el('a', { href: 'assets/images/home/gallery/MossCo-Cafe-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/MossCo-Cafe-min.jpg', className: 'h-full object-cover w-full', loading: 'lazy', sizes: '100vw,
(min-width: 640px) 640px,
(min-width: 768px) 249px,
(min-width: 1024px) 335px,
(min-width: 1280px) 420px,
(min-width: 1536px) 505px' })), ' ']), ' ', el('div', { className: 'gallery-item-2' }, [' ', el('a', { href: 'assets/images/home/gallery/delights-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/delights-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-2 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-3' }, [el('a', { href: 'assets/images/home/gallery/pasteries-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/pasteries-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-3 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-4' }, [el('a', { href: 'assets/images/home/gallery/Reception-with-Hello-Welcome-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Reception-with-Hello-Welcome-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-4 h-full object-center object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-5' }, [el('a', { href: 'assets/images/home/gallery/TL-Townsend-St_Bar-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/TL-Townsend-St_Bar-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-5 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-6' }, [' ', el('a', { href: 'assets/images/home/gallery/Mossco-Restaurant-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Mossco-Restaurant-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-6 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-7' }, [' ', el('a', { href: 'assets/images/home/gallery/Mossco-Restaurant-2-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Mossco-Restaurant-2-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-7 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-8' }, [' ', el('a', { href: 'assets/images/home/gallery/Travelodge-Plus-Lobby-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Travelodge-Plus-Lobby-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-8 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-9' }, [' ', el('a', { href: 'assets/images/home/gallery/Travelodge-Plus-Terrace-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Travelodge-Plus-Terrace-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-9 h-full object-cover w-full' })), ' ']), ' ', ' ']), ' ', el('div', { className: 'mx-auto pt-10 px-4 w-full md:pt-12 md:pt-20 md:px-0 md:w-2/3 md:w-4/5', 'data-pg-ia-hide': '' }, [' ', el('p', { className: 'font-normal font-serif text-base text-white lg:text-gray-200' }, [el('span', { className: 'text-primary-NORMAL' }, 'Mossco café'), ' is a lively, fun, and friendly café that serves a fantastic range of coffees and cakes, along with an ever-changing range of daily specials.']), ' ', el('p', { className: 'font-normal font-serif pt-2 text-base text-white lg:text-gray-200' }, 'It is a relaxed café in the heart of Dublin city centre.'), ' ']), ' ']), ' '])),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.mc_gallery_heading,
                                        help: __( '' ),
                                        label: __( 'Gallery Heading' ),
                                        onChange: function(val) { setAttributes({mc_gallery_heading: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ 'data-empty-placeholder': null, 'data-pg-name': 'Gallery Wrapper' });
            return el('div', { ...blockProps }, el('section', { id: 'home-gallery', 'data-pg-ia-scene': '{"l":[{"name":"MENUS Header","t":"h3","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%"},{"t":"#gt# div #gt# div:nth-of-type(2)","p":"time","s":"30%","rev":"true","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]}}]}', 'data-pgc': 'mossco-gallery', 'data-pgc-no-update': '' }, [' ', el('div', { className: 'container max-w-screen-xl mx-auto py-16 md:py-16' }, [' ', el(RichText.Content, { tagName: 'h3', className: 'pb-8 text-3xl text-center text-primary-NORMAL uppercase md:pb-10 md:pb-6', 'data-pg-ia-hide': 'null', value: propOrDefault( props.attributes.mc_gallery_heading, 'mc_gallery_heading' ) }), ' ', el('div', { className: 'mossco-gallery-grid' }, [' ', el('div', { className: 'gallery-item-1' }, [' ', el('a', { href: 'assets/images/home/gallery/MossCo-Cafe-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/MossCo-Cafe-min.jpg', className: 'h-full object-cover w-full', loading: 'lazy', sizes: '100vw,
(min-width: 640px) 640px,
(min-width: 768px) 249px,
(min-width: 1024px) 335px,
(min-width: 1280px) 420px,
(min-width: 1536px) 505px' })), ' ']), ' ', el('div', { className: 'gallery-item-2' }, [' ', el('a', { href: 'assets/images/home/gallery/delights-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/delights-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-2 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-3' }, [el('a', { href: 'assets/images/home/gallery/pasteries-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/pasteries-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-3 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-4' }, [el('a', { href: 'assets/images/home/gallery/Reception-with-Hello-Welcome-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Reception-with-Hello-Welcome-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-4 h-full object-center object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-5' }, [el('a', { href: 'assets/images/home/gallery/TL-Townsend-St_Bar-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/TL-Townsend-St_Bar-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-5 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-6' }, [' ', el('a', { href: 'assets/images/home/gallery/Mossco-Restaurant-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Mossco-Restaurant-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-6 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-7' }, [' ', el('a', { href: 'assets/images/home/gallery/Mossco-Restaurant-2-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Mossco-Restaurant-2-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-7 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-8' }, [' ', el('a', { href: 'assets/images/home/gallery/Travelodge-Plus-Lobby-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Travelodge-Plus-Lobby-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-8 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-9' }, [' ', el('a', { href: 'assets/images/home/gallery/Travelodge-Plus-Terrace-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/home/gallery/Travelodge-Plus-Terrace-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-9 h-full object-cover w-full' })), ' ']), ' ', ' ']), ' ', el('div', { className: 'mx-auto pt-10 px-4 w-full md:pt-12 md:pt-20 md:px-0 md:w-2/3 md:w-4/5', 'data-pg-ia-hide': '' }, [' ', el('p', { className: 'font-normal font-serif text-base text-white lg:text-gray-200' }, [el('span', { className: 'text-primary-NORMAL' }, 'Mossco café'), ' is a lively, fun, and friendly café that serves a fantastic range of coffees and cakes, along with an ever-changing range of daily specials.']), ' ', el('p', { className: 'font-normal font-serif pt-2 text-base text-white lg:text-gray-200' }, 'It is a relaxed café in the heart of Dublin city centre.'), ' ']), ' ']), ' ']));
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
