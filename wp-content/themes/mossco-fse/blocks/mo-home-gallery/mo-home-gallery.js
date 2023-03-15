
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
    
    const block = registerBlockType( 'mossco-fse/mo-home-gallery', {
        apiVersion: 2,
        title: 'Home Gallery Block',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M22 9.999V20a1 1 0 0 1-1 1h-8V9.999h9zm-11 6V21H3a1 1 0 0 1-1-1v-4.001h9zM11 3v10.999H2V4a1 1 0 0 1 1-1h8zm10 0a1 1 0 0 1 1 1v3.999h-9V3h8z' })]),
        category: 'mo_home_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_gallery_heading: {
                type: 'text',
                default: `Gallery`,
            }
        },
        example: { attributes: { mo_gallery_heading: `Gallery` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ id: 'home-gallery' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: 'container max-w-screen-xl mx-auto py-16 md:py-16' }, [' ', el(RichText, { tagName: 'h3', className: 'pb-8 text-3xl text-center text-primary-NORMAL uppercase md:pb-10 md:pb-6', value: propOrDefault( props.attributes.mo_gallery_heading, 'mo_gallery_heading' ), onChange: function(val) { setAttributes( {mo_gallery_heading: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el('div', { className: 'mossco-gallery-grid' }, [' ', el('div', { className: 'gallery-item-1' }, [' ', el('a', { href: 'assets/images/home/gallery/MossCo-Cafe-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/MossCo-Cafe-min.jpg', className: 'h-full object-cover w-full', loading: 'lazy' })), ' ']), ' ', el('div', { className: 'gallery-item-2' }, [' ', el('a', { href: 'assets/images/home/gallery/delights-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/delights-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-2 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-3' }, [el('a', { href: 'assets/images/home/gallery/pasteries-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/pasteries-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-3 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-4' }, [el('a', { href: 'assets/images/home/gallery/Reception-with-Hello-Welcome-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Reception-with-Hello-Welcome-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-4 h-full object-center object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-5' }, [el('a', { href: 'assets/images/home/gallery/TL-Townsend-St_Bar-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/TL-Townsend-St_Bar-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-5 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-6' }, [' ', el('a', { href: 'assets/images/home/gallery/Mossco-Restaurant-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Mossco-Restaurant-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-6 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-7' }, [' ', el('a', { href: 'assets/images/home/gallery/Mossco-Restaurant-2-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Mossco-Restaurant-2-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-7 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-8' }, [' ', el('a', { href: 'assets/images/home/gallery/Travelodge-Plus-Lobby-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Travelodge-Plus-Lobby-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-8 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-9' }, [' ', el('a', { href: 'assets/images/home/gallery/Travelodge-Plus-Terrace-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Travelodge-Plus-Terrace-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-9 h-full object-cover w-full' })), ' ']), ' ']), ' ', el('div', { className: 'mx-auto pt-10 px-4 w-full md:pt-12 md:pt-20 md:px-0 md:w-2/3 md:w-4/5' }, [' ', el('p', { className: 'font-normal font-serif text-base text-white lg:text-gray-200' }, [el('span', { className: 'text-primary-NORMAL' }, 'Mossco café'), ' is a lively, fun, and friendly café that serves a fantastic range of coffees and cakes, along with an ever-changing range of daily specials.']), ' ', el('p', { className: 'font-normal font-serif pt-2 text-base text-white lg:text-gray-200' }, 'It is a relaxed café in the heart of Dublin city centre.'), ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.mo_gallery_heading,
                                        help: __( '' ),
                                        label: __( 'Section Heading Text' ),
                                        onChange: function(val) { setAttributes({mo_gallery_heading: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ id: 'home-gallery' });
            return el('section', { ...blockProps }, [' ', el('div', { className: 'container max-w-screen-xl mx-auto py-16 md:py-16' }, [' ', el(RichText.Content, { tagName: 'h3', className: 'pb-8 text-3xl text-center text-primary-NORMAL uppercase md:pb-10 md:pb-6', value: propOrDefault( props.attributes.mo_gallery_heading, 'mo_gallery_heading' ) }), ' ', el('div', { className: 'mossco-gallery-grid' }, [' ', el('div', { className: 'gallery-item-1' }, [' ', el('a', { href: 'assets/images/home/gallery/MossCo-Cafe-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/MossCo-Cafe-min.jpg', className: 'h-full object-cover w-full', loading: 'lazy' })), ' ']), ' ', el('div', { className: 'gallery-item-2' }, [' ', el('a', { href: 'assets/images/home/gallery/delights-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/delights-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-2 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-3' }, [el('a', { href: 'assets/images/home/gallery/pasteries-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/pasteries-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-3 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-4' }, [el('a', { href: 'assets/images/home/gallery/Reception-with-Hello-Welcome-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Reception-with-Hello-Welcome-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-4 h-full object-center object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-5' }, [el('a', { href: 'assets/images/home/gallery/TL-Townsend-St_Bar-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/TL-Townsend-St_Bar-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-5 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-6' }, [' ', el('a', { href: 'assets/images/home/gallery/Mossco-Restaurant-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Mossco-Restaurant-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-6 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-7' }, [' ', el('a', { href: 'assets/images/home/gallery/Mossco-Restaurant-2-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Mossco-Restaurant-2-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-7 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-8' }, [' ', el('a', { href: 'assets/images/home/gallery/Travelodge-Plus-Lobby-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Travelodge-Plus-Lobby-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-8 h-full object-cover w-full' })), ' ']), ' ', el('div', { className: 'gallery-item-9' }, [' ', el('a', { href: 'assets/images/home/gallery/Travelodge-Plus-Terrace-min.jpg', 'data-fancybox': 'gallery' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/gallery/Travelodge-Plus-Terrace-min.jpg', loading: 'lazy', width: '100', height: '100', className: 'gallery-item-9 h-full object-cover w-full' })), ' ']), ' ']), ' ', el('div', { className: 'mx-auto pt-10 px-4 w-full md:pt-12 md:pt-20 md:px-0 md:w-2/3 md:w-4/5' }, [' ', el('p', { className: 'font-normal font-serif text-base text-white lg:text-gray-200' }, [el('span', { className: 'text-primary-NORMAL' }, 'Mossco café'), ' is a lively, fun, and friendly café that serves a fantastic range of coffees and cakes, along with an ever-changing range of daily specials.']), ' ', el('p', { className: 'font-normal font-serif pt-2 text-base text-white lg:text-gray-200' }, 'It is a relaxed café in the heart of Dublin city centre.'), ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
