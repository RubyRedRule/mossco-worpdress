
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
    
    const block = registerBlockType( 'mossco-hc/mo-home-header', {
        apiVersion: 2,
        title: 'Mossco Home Header',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M19 12H5v7h14v-7zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z' })]),
        category: 'mo_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            inner_nav_item_1_link: {
                type: 'object',
                default: {post_id: 0, url: '#home-our-brand', title: '', 'post_type': null},
            },
            inner_nav_item_1_text: {
                type: 'text',
                default: `Our Story`,
            },
            inner_nav_item_2_link: {
                type: 'object',
                default: {post_id: 0, url: '#home-menus', title: '', 'post_type': null},
            },
            inner_nav_item_2_text: {
                type: 'text',
                default: `Menus`,
            },
            inner_nav_item_3_link: {
                type: 'object',
                default: {post_id: 0, url: '#home-bar', title: '', 'post_type': null},
            },
            inner_nav_item_3_text: {
                type: 'text',
                default: `Bar &#38; Restaurant`,
            },
            inner_book_button_colour: {
                type: 'text',
                default: '',
            },
            inner_book_button_text: {
                type: 'text',
                default: `Book a Table`,
            }
        },
        example: { attributes: { inner_nav_item_1_link: {post_id: 0, url: '#home-our-brand', title: '', 'post_type': null}, inner_nav_item_1_text: `Our Story`, inner_nav_item_2_link: {post_id: 0, url: '#home-menus', title: '', 'post_type': null}, inner_nav_item_2_text: `Menus`, inner_nav_item_3_link: {post_id: 0, url: '#home-bar', title: '', 'post_type': null}, inner_nav_item_3_text: `Bar &#38; Restaurant`, inner_book_button_colour: '', inner_book_button_text: `Book a Table` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ 'data-pg-name': 'Header Wrapper' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('div', { ...blockProps }, [' ', el('div', { className: 'bg-Mossco-grey-background bg-opacity-0 duration-500 false-header h-24 origin-top sticky top-0 transform transition z-50 sm:h-28', 'data-pg-ia-hide': '' }, [' ', el('div', { 'data-empty-placeholder': '' }), ' ']), ' ', el('div', { className: '-mt-28 container duration-500 h-24 mossco-header mx-auto px-0 sticky top-1 transform transition z-50 md:top-0 lg:top-2 2xl:max-w-screen-xl' }, [' ', ' ', el('nav', { className: 'flex flex-wrap items-center justify-between p-4 sm:py-5 md:px-4 lg:py-0' }, [' ', el('a', { href: 'index.html' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/logo/logo-white-teal.svg', className: 'drop-shadow-xl duration-500 h-9 ml-4 mossco-logo mr-auto scale-125 transform transition lg:h-9' })), ' ', el('button', { className: 'hamburger-menu hover:text-white ml-auto py-2 rounded text-current md:mr-5 lg:hidden', 'data-name': 'nav-toggler', 'data-pg-ia': '{"l":[{"trg":"click","a":{"l":[{"t":"^nav|[data-name=nav-menu]","l":[{"t":"set","p":0,"d":0,"l":{"class.remove":"hidden","autoAlpha":0}},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1}}]},{"t":"#gt# span:nth-of-type(1)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":45,"yPercent":300}}]},{"t":"#gt# span:nth-of-type(2)","l":[{"t":"tween","p":0,"d":0.2,"l":{"autoAlpha":0}}]},{"t":"#gt# span:nth-of-type(3)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":-45,"yPercent":-400}}]},{"t":"$body","l":[{"t":"set","p":0,"d":0,"l":{"class.add":"bg-blend-overlay"}}]}]},"pdef":"true","trev":"true","name":"NavMenuToggler"}]}', 'data-pg-ia-apply': '$nav [data-name=nav-toggler]', 'data-pg-ia-hide': '' }, [' ', el('span', { className: 'bg-primary-NORMAL block h-1 hover:bg-primary-LIGHT my-2 rounded ml-auto w-10 sm:w-12' }), ' ', el('span', { className: 'bg-white block h-1 ml-auto my-2.5 rounded w-6 sm:w-8' }), ' ', el('span', { className: 'bg-primary-NORMAL block h-1 hover: my-2.5 rounded ml-auto w-10 sm:w-12' }), ' ']), ' ', el('script', { src: 'pgia/lib/pgia.js' }), ' ', el('a', { href: '#', className: 'bg-primary-NORMAL font-light hover:bg-primary-700 inline-block nav-btn-tablet-mobile px-5 py-2 rounded text-current text-primary-500 uppercase sm:hidden md:inline-block lg:hidden', 'data-pg-ia-hide': '' }, 'Book a Table'), ' ', el('div', { className: 'bg-Mossco-grey-dark bg-opacity-95 hidden lg:bg-opacity-0 lg:flex lg:max-w-full lg:space-x-4 lg:space-y-0 lg:text-left lg:w-auto md:max-w-md md:mr-0 mx-auto pl-4 py-8 rounded space-y-2 text-center w-full', 'data-name': 'nav-menu', 'data-pg-ia-hide': '', 'data-pg-name': 'Nav links div' }, [' ', ' ', el('ul', { className: 'flex flex-col font-normal text-gray-50 lg:flex-row lg:text-sm' }, [' ', el(RichText, { tagName: 'a', href: propOrDefault( props.attributes.inner_nav_item_1_link.url, 'inner_nav_item_1_link', 'url' ), className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4', onClick: function(e) { e.preventDefault(); }, value: propOrDefault( props.attributes.inner_nav_item_1_text, 'inner_nav_item_1_text' ), onChange: function(val) { setAttributes( {inner_nav_item_1_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'a', href: propOrDefault( props.attributes.inner_nav_item_2_link.url, 'inner_nav_item_2_link', 'url' ), className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4', onClick: function(e) { e.preventDefault(); }, value: propOrDefault( props.attributes.inner_nav_item_2_text, 'inner_nav_item_2_text' ), onChange: function(val) { setAttributes( {inner_nav_item_2_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'a', href: propOrDefault( props.attributes.inner_nav_item_3_link.url, 'inner_nav_item_3_link', 'url' ), className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4', onClick: function(e) { e.preventDefault(); }, value: propOrDefault( props.attributes.inner_nav_item_3_text, 'inner_nav_item_3_text' ), onChange: function(val) { setAttributes( {inner_nav_item_3_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el('a', { href: '#home-gallery', className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4' }, 'Gallery'), ' ', el('a', { href: '#details-map', className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4' }, 'Location'), ' ', el('a', { href: '#home-newsletter', className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4' }, 'Newsletter'), ' ']), ' ', el(RichText, { tagName: 'a', href: '#', className: 'active:bg-primary-DARK bg-primary-NORMAL duration-300 ease-out hover:bg-primary-LIGHT hover:ring hover:ring-primary-DARK inline-block px-5 py-2 rounded text-white transition uppercase', style: { background: propOrDefault( props.attributes.inner_book_button_colour, 'inner_book_button_colour' ) }, value: propOrDefault( props.attributes.inner_book_button_text, 'inner_book_button_text' ), onChange: function(val) { setAttributes( {inner_book_button_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', ' ']), ' ', ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    pgUrlControl('inner_nav_item_1_link', setAttributes, props, 'Navigation Item 1 link', '', null ),
                                    el(TextControl, {
                                        value: props.attributes.inner_nav_item_1_text,
                                        help: __( '' ),
                                        label: __( 'Navigation Item 1 text' ),
                                        onChange: function(val) { setAttributes({inner_nav_item_1_text: val}) },
                                        type: 'text'
                                    }),
                                    pgUrlControl('inner_nav_item_2_link', setAttributes, props, 'Navigation Item 2 link', '', null ),
                                    el(TextareaControl, {
                                        value: props.attributes.inner_nav_item_2_text,
                                        help: __( '' ),
                                        label: __( 'Navigation Item 2 text' ),
                                        onChange: function(val) { setAttributes({inner_nav_item_2_text: val}) },
                                    }),
                                    pgUrlControl('inner_nav_item_3_link', setAttributes, props, 'Navigation Item 3 link', '', null ),
                                    el(TextControl, {
                                        value: props.attributes.inner_nav_item_3_text,
                                        help: __( '' ),
                                        label: __( 'Navigation Item 3 text' ),
                                        onChange: function(val) { setAttributes({inner_nav_item_3_text: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.inner_book_button_colour,
                                        help: __( '' ),
                                        label: __( 'Button Colour' ),
                                        onChange: function(val) { setAttributes({inner_book_button_colour: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.inner_book_button_text,
                                        help: __( '' ),
                                        label: __( 'Button Text' ),
                                        onChange: function(val) { setAttributes({inner_book_button_text: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ 'data-pg-name': 'Header Wrapper' });
            return el('div', { ...blockProps }, [' ', el('div', { className: 'bg-Mossco-grey-background bg-opacity-0 duration-500 false-header h-24 origin-top sticky top-0 transform transition z-50 sm:h-28', 'data-pg-ia-hide': '' }, [' ', el('div', { 'data-empty-placeholder': '' }), ' ']), ' ', el('div', { className: '-mt-28 container duration-500 h-24 mossco-header mx-auto px-0 sticky top-1 transform transition z-50 md:top-0 lg:top-2 2xl:max-w-screen-xl' }, [' ', ' ', el('nav', { className: 'flex flex-wrap items-center justify-between p-4 sm:py-5 md:px-4 lg:py-0' }, [' ', el('a', { href: 'index.html' }, el('img', { src: (pg_project_data_mossco_hc ? pg_project_data_mossco_hc.url : '') + 'assets/images/logo/logo-white-teal.svg', className: 'drop-shadow-xl duration-500 h-9 ml-4 mossco-logo mr-auto scale-125 transform transition lg:h-9' })), ' ', el('button', { className: 'hamburger-menu hover:text-white ml-auto py-2 rounded text-current md:mr-5 lg:hidden', 'data-name': 'nav-toggler', 'data-pg-ia': '{"l":[{"trg":"click","a":{"l":[{"t":"^nav|[data-name=nav-menu]","l":[{"t":"set","p":0,"d":0,"l":{"class.remove":"hidden","autoAlpha":0}},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1}}]},{"t":"#gt# span:nth-of-type(1)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":45,"yPercent":300}}]},{"t":"#gt# span:nth-of-type(2)","l":[{"t":"tween","p":0,"d":0.2,"l":{"autoAlpha":0}}]},{"t":"#gt# span:nth-of-type(3)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":-45,"yPercent":-400}}]},{"t":"$body","l":[{"t":"set","p":0,"d":0,"l":{"class.add":"bg-blend-overlay"}}]}]},"pdef":"true","trev":"true","name":"NavMenuToggler"}]}', 'data-pg-ia-apply': '$nav [data-name=nav-toggler]', 'data-pg-ia-hide': '' }, [' ', el('span', { className: 'bg-primary-NORMAL block h-1 hover:bg-primary-LIGHT my-2 rounded ml-auto w-10 sm:w-12' }), ' ', el('span', { className: 'bg-white block h-1 ml-auto my-2.5 rounded w-6 sm:w-8' }), ' ', el('span', { className: 'bg-primary-NORMAL block h-1 hover: my-2.5 rounded ml-auto w-10 sm:w-12' }), ' ']), ' ', el('script', { src: 'pgia/lib/pgia.js' }), ' ', el('a', { href: '#', className: 'bg-primary-NORMAL font-light hover:bg-primary-700 inline-block nav-btn-tablet-mobile px-5 py-2 rounded text-current text-primary-500 uppercase sm:hidden md:inline-block lg:hidden', 'data-pg-ia-hide': '' }, 'Book a Table'), ' ', el('div', { className: 'bg-Mossco-grey-dark bg-opacity-95 hidden lg:bg-opacity-0 lg:flex lg:max-w-full lg:space-x-4 lg:space-y-0 lg:text-left lg:w-auto md:max-w-md md:mr-0 mx-auto pl-4 py-8 rounded space-y-2 text-center w-full', 'data-name': 'nav-menu', 'data-pg-ia-hide': '', 'data-pg-name': 'Nav links div' }, [' ', ' ', el('ul', { className: 'flex flex-col font-normal text-gray-50 lg:flex-row lg:text-sm' }, [' ', el(RichText.Content, { tagName: 'a', href: propOrDefault( props.attributes.inner_nav_item_1_link.url, 'inner_nav_item_1_link', 'url' ), className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4', value: propOrDefault( props.attributes.inner_nav_item_1_text, 'inner_nav_item_1_text' ) }), ' ', el(RichText.Content, { tagName: 'a', href: propOrDefault( props.attributes.inner_nav_item_2_link.url, 'inner_nav_item_2_link', 'url' ), className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4', value: propOrDefault( props.attributes.inner_nav_item_2_text, 'inner_nav_item_2_text' ) }), ' ', el(RichText.Content, { tagName: 'a', href: propOrDefault( props.attributes.inner_nav_item_3_link.url, 'inner_nav_item_3_link', 'url' ), className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4', value: propOrDefault( props.attributes.inner_nav_item_3_text, 'inner_nav_item_3_text' ) }), ' ', el('a', { href: '#home-gallery', className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4' }, 'Gallery'), ' ', el('a', { href: '#details-map', className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4' }, 'Location'), ' ', el('a', { href: '#home-newsletter', className: 'hover:text-primary-LIGHT px-0 py-2 uppercase lg:px-4' }, 'Newsletter'), ' ']), ' ', el(RichText.Content, { tagName: 'a', href: '#', className: 'active:bg-primary-DARK bg-primary-NORMAL duration-300 ease-out hover:bg-primary-LIGHT hover:ring hover:ring-primary-DARK inline-block px-5 py-2 rounded text-white transition uppercase', style: { background: propOrDefault( props.attributes.inner_book_button_colour, 'inner_book_button_colour' ) }, value: propOrDefault( props.attributes.inner_book_button_text, 'inner_book_button_text' ) }), ' ', ' ']), ' ', ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
