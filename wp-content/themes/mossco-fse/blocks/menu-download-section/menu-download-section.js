
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
    
    const block = registerBlockType( 'mossco-fse/menu-download-section', {
        apiVersion: 2,
        title: 'Menu Download Button Section',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm1 10V8h-2v4H8l4 4 4-4h-3z' })]),
        category: 'mo_menu_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            menu_download_link: {
                type: 'object',
                default: {post_id: 0, url: '', title: '', 'post_type': null},
            },
            menu_download_btn_text: {
                type: 'text',
                default: `Download Menu   <svg class="fill-current h-6 ml-2 my-auto w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor"> <path d="M369.9 97.98L286.02 14.1c-9-9-21.2-14.1-33.89-14.1H47.99C21.5.1 0 21.6 0 48.09v415.92C0 490.5 21.5 512 47.99 512h288.02c26.49 0 47.99-21.5 47.99-47.99V131.97c0-12.69-5.1-24.99-14.1-33.99zM256.03 32.59c2.8.7 5.3 2.1 7.4 4.2l83.88 83.88c2.1 2.1 3.5 4.6 4.2 7.4h-95.48V32.59zm95.98 431.42c0 8.8-7.2 16-16 16H47.99c-8.8 0-16-7.2-16-16V48.09c0-8.8 7.2-16.09 16-16.09h176.04v104.07c0 13.3 10.7 23.93 24 23.93h103.98v304.01zM208 216c0-4.42-3.58-8-8-8h-16c-4.42 0-8 3.58-8 8v88.02h-52.66c-11 0-20.59 6.41-25 16.72-4.5 10.52-2.38 22.62 5.44 30.81l68.12 71.78c5.34 5.59 12.47 8.69 20.09 8.69s14.75-3.09 20.09-8.7l68.12-71.75c7.81-8.2 9.94-20.31 5.44-30.83-4.41-10.31-14-16.72-25-16.72H208V216zm42.84 120.02l-58.84 62-58.84-62h117.68z"/> </svg>`,
            },
            menu_download_btn_bg: {
                type: 'text',
                default: '',
            },
            menu_download_btn_br: {
                type: 'text',
                default: '',
            },
            menu_download_icon: {
                type: 'object',
                default: {id: 0, url: '', size: '', svg: `<svg class="fill-current h-6 ml-2 my-auto w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor">
    <path d="M369.9 97.98L286.02 14.1c-9-9-21.2-14.1-33.89-14.1H47.99C21.5.1 0 21.6 0 48.09v415.92C0 490.5 21.5 512 47.99 512h288.02c26.49 0 47.99-21.5 47.99-47.99V131.97c0-12.69-5.1-24.99-14.1-33.99zM256.03 32.59c2.8.7 5.3 2.1 7.4 4.2l83.88 83.88c2.1 2.1 3.5 4.6 4.2 7.4h-95.48V32.59zm95.98 431.42c0 8.8-7.2 16-16 16H47.99c-8.8 0-16-7.2-16-16V48.09c0-8.8 7.2-16.09 16-16.09h176.04v104.07c0 13.3 10.7 23.93 24 23.93h103.98v304.01zM208 216c0-4.42-3.58-8-8-8h-16c-4.42 0-8 3.58-8 8v88.02h-52.66c-11 0-20.59 6.41-25 16.72-4.5 10.52-2.38 22.62 5.44 30.81l68.12 71.78c5.34 5.59 12.47 8.69 20.09 8.69s14.75-3.09 20.09-8.7l68.12-71.75c7.81-8.2 9.94-20.31 5.44-30.83-4.41-10.31-14-16.72-25-16.72H208V216zm42.84 120.02l-58.84 62-58.84-62h117.68z"/>
</svg>`, alt: null},
            }
        },
        example: { attributes: { menu_download_link: {post_id: 0, url: '', title: '', 'post_type': null}, menu_download_btn_text: `Download Menu   <svg class="fill-current h-6 ml-2 my-auto w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor"> <path d="M369.9 97.98L286.02 14.1c-9-9-21.2-14.1-33.89-14.1H47.99C21.5.1 0 21.6 0 48.09v415.92C0 490.5 21.5 512 47.99 512h288.02c26.49 0 47.99-21.5 47.99-47.99V131.97c0-12.69-5.1-24.99-14.1-33.99zM256.03 32.59c2.8.7 5.3 2.1 7.4 4.2l83.88 83.88c2.1 2.1 3.5 4.6 4.2 7.4h-95.48V32.59zm95.98 431.42c0 8.8-7.2 16-16 16H47.99c-8.8 0-16-7.2-16-16V48.09c0-8.8 7.2-16.09 16-16.09h176.04v104.07c0 13.3 10.7 23.93 24 23.93h103.98v304.01zM208 216c0-4.42-3.58-8-8-8h-16c-4.42 0-8 3.58-8 8v88.02h-52.66c-11 0-20.59 6.41-25 16.72-4.5 10.52-2.38 22.62 5.44 30.81l68.12 71.78c5.34 5.59 12.47 8.69 20.09 8.69s14.75-3.09 20.09-8.7l68.12-71.75c7.81-8.2 9.94-20.31 5.44-30.83-4.41-10.31-14-16.72-25-16.72H208V216zm42.84 120.02l-58.84 62-58.84-62h117.68z"/> </svg>`, menu_download_btn_bg: '', menu_download_btn_br: '', menu_download_icon: {id: 0, url: '', size: '', svg: `<svg class="fill-current h-6 ml-2 my-auto w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor">
    <path d="M369.9 97.98L286.02 14.1c-9-9-21.2-14.1-33.89-14.1H47.99C21.5.1 0 21.6 0 48.09v415.92C0 490.5 21.5 512 47.99 512h288.02c26.49 0 47.99-21.5 47.99-47.99V131.97c0-12.69-5.1-24.99-14.1-33.99zM256.03 32.59c2.8.7 5.3 2.1 7.4 4.2l83.88 83.88c2.1 2.1 3.5 4.6 4.2 7.4h-95.48V32.59zm95.98 431.42c0 8.8-7.2 16-16 16H47.99c-8.8 0-16-7.2-16-16V48.09c0-8.8 7.2-16.09 16-16.09h176.04v104.07c0 13.3 10.7 23.93 24 23.93h103.98v304.01zM208 216c0-4.42-3.58-8-8-8h-16c-4.42 0-8 3.58-8 8v88.02h-52.66c-11 0-20.59 6.41-25 16.72-4.5 10.52-2.38 22.62 5.44 30.81l68.12 71.78c5.34 5.59 12.47 8.69 20.09 8.69s14.75-3.09 20.09-8.7l68.12-71.75c7.81-8.2 9.94-20.31 5.44-30.83-4.41-10.31-14-16.72-25-16.72H208V216zm42.84 120.02l-58.84 62-58.84-62h117.68z"/>
</svg>`, alt: null} } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ id: 'download-menu', className: 'bottom-0 container flex items-center justify-center max-w-screen-xl ml-auto mx-auto px-4 rounded-md sticky xl:pr-2 2xl:pr-0', 'data-pg-ia-scene': '{"l":[{"t":"#gt# div:nth-of-type(1) #gt# div:nth-of-type(2)","p":"time","a":{"l":[{"t":"","l":[{"t":"set","p":1.3,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.3,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]}}]}', 'data-pg-name': 'Download Button' });
            const setAttributes = props.setAttributes; 
            
            props.menu_download_icon = useSelect(function( select ) {
                return {
                    menu_download_icon: props.attributes.menu_download_icon.id ? select('core').getMedia(props.attributes.menu_download_icon.id) : undefined
                };
            }, [props.attributes.menu_download_icon] ).menu_download_icon;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: 'container flex grid grid-cols-1 items-end justify-end px-0 sm:grid-cols-1 md:grid-cols-2 md:px-4 lg:grid-cols-3 lg:justify-center lg:px-4 xl:justify-center xl:px-5 2xl:justify-center 2xl:px-6' }, [' ', el('div', { className: 'col-span-2 hidden sm:col-span-1 sm:hidden md:col-span-1 md:flex lg:col-span-2', 'data-empty-placeholder': '' }), ' ', el('div', { className: 'bg-Mossco-grey-dark bg-opacity-25 col-span-1 flex h-full items-center justify-center my-auto py-6 rounded-sm md:py-8', 'data-pg-ia-hide': '' }, [' ', el(RichText, { tagName: 'a', className: 'active:bg-primary-DARK active:border-primary-DARK bg-opacity-50 bg-primary-NORMAL border-2 border-primary-NORMAL border-solid bottom-0 cursor-pointer drop-shadow duration-300 ease-out flex font-sans hover:bg-primary-LIGHT hover:border-primary-LIGHT hover:drop-shadow-xl hover:ring hover:ring-primary-DARK hover:rounded-sm hover:text-white items-center justify-center px-8 py-4 rounded uppercase w-auto lg:font-medium 2xl:bg-primary-NORMAL', onClick: function(e) { e.preventDefault(); }, href: propOrDefault( props.attributes.menu_download_link.url, 'menu_download_link', 'url' ), style: { backgroundColor: propOrDefault( props.attributes.menu_download_btn_bg, 'menu_download_btn_bg' ),borderColor: propOrDefault( props.attributes.menu_download_btn_br, 'menu_download_btn_br' ) }, value: propOrDefault( props.attributes.menu_download_btn_text, 'menu_download_btn_text' ), onChange: function(val) { setAttributes( {menu_download_btn_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ']), ' ', el('div', { 'data-empty-placeholder': '' }), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('menu_download_icon', setAttributes, props, 'full', true, 'Menu Download Icon SVG', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    pgUrlControl('menu_download_link', setAttributes, props, 'Button Download Link', '', null ),
                                    el(TextControl, {
                                        value: props.attributes.menu_download_btn_text,
                                        help: __( '' ),
                                        label: __( 'Button Download Text' ),
                                        onChange: function(val) { setAttributes({menu_download_btn_text: val}) },
                                        type: 'text'
                                    }),
                                    pgColorControl('menu_download_btn_bg', setAttributes, props, 'Button Background Colour', ''),

                                    pgColorControl('menu_download_btn_br', setAttributes, props, 'Download Button Border Colour', ''),
    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ id: 'download-menu', className: 'bottom-0 container flex items-center justify-center max-w-screen-xl ml-auto mx-auto px-4 rounded-md sticky xl:pr-2 2xl:pr-0', 'data-pg-ia-scene': '{"l":[{"t":"#gt# div:nth-of-type(1) #gt# div:nth-of-type(2)","p":"time","a":{"l":[{"t":"","l":[{"t":"set","p":1.3,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":1.3,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]}}]}', 'data-pg-name': 'Download Button' });
            return el('section', { ...blockProps }, [' ', el('div', { className: 'container flex grid grid-cols-1 items-end justify-end px-0 sm:grid-cols-1 md:grid-cols-2 md:px-4 lg:grid-cols-3 lg:justify-center lg:px-4 xl:justify-center xl:px-5 2xl:justify-center 2xl:px-6' }, [' ', el('div', { className: 'col-span-2 hidden sm:col-span-1 sm:hidden md:col-span-1 md:flex lg:col-span-2', 'data-empty-placeholder': '' }), ' ', el('div', { className: 'bg-Mossco-grey-dark bg-opacity-25 col-span-1 flex h-full items-center justify-center my-auto py-6 rounded-sm md:py-8', 'data-pg-ia-hide': '' }, [' ', el(RichText.Content, { tagName: 'a', className: 'active:bg-primary-DARK active:border-primary-DARK bg-opacity-50 bg-primary-NORMAL border-2 border-primary-NORMAL border-solid bottom-0 cursor-pointer drop-shadow duration-300 ease-out flex font-sans hover:bg-primary-LIGHT hover:border-primary-LIGHT hover:drop-shadow-xl hover:ring hover:ring-primary-DARK hover:rounded-sm hover:text-white items-center justify-center px-8 py-4 rounded uppercase w-auto lg:font-medium 2xl:bg-primary-NORMAL', href: propOrDefault( props.attributes.menu_download_link.url, 'menu_download_link', 'url' ), style: { backgroundColor: propOrDefault( props.attributes.menu_download_btn_bg, 'menu_download_btn_bg' ),borderColor: propOrDefault( props.attributes.menu_download_btn_br, 'menu_download_btn_br' ) }, value: propOrDefault( props.attributes.menu_download_btn_text, 'menu_download_btn_text' ) }), ' ']), ' ']), ' ', el('div', { 'data-empty-placeholder': '' }), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
