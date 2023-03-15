
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
    
    const block = registerBlockType( 'mossco-fse/mo-menu-header', {
        apiVersion: 2,
        title: 'Mossco Menu Header',
        description: '',
        icon: 'block-default',
        category: 'mo_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_nav_button_link: {
                type: 'object',
                default: {post_id: 0, url: '#', title: '', 'post_type': null},
            },
            mo_nav_button_text: {
                type: 'text',
                default: `Book a Table`,
            }
        },
        example: { attributes: { mo_nav_button_link: {post_id: 0, url: '#', title: '', 'post_type': null}, mo_nav_button_text: `Book a Table` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'h-24 sm:h-28 sticky top-0 z-50', 'data-pgc-define': 'mossco-navbar-menus', 'data-pgc-define-name': 'Mossco Navbar Menus', 'data-pgc-section': 'Mossco Headers and Footers', 'data-pg-ia-scene': '{"l":[{"name":"burger menu","t":"button","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0%"},{"name":"book table button tablet","t":"nav #gt# a:nth-of-type(2)","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]}}]}' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = useInnerBlocksProps({ className: 'flex flex-col items-center md:text-center lg:flex-row' }, {
                allowedBlocks: [ 'mossco-fse/inner-menu-nav-link', 'mossco-fse/inner-menu-nav-item-text' ],
                template: [
    [ 'mossco-fse/mo-menu-nav-links', {} ],
    [ 'mossco-fse/mo-menu-nav-links', {} ],
    [ 'mossco-fse/mo-menu-nav-links', {} ]
],
            } );
                            
            
            return el(Fragment, {}, [
                el('header', { ...blockProps }, [' ', el('div', { className: 'bg-Mossco-grey-background bg-opacity-0 duration-500 false-header h-24 origin-top sticky top-0 transform transition z-50 sm:h-28' }, [' ', el('div', { 'data-empty-placeholder': '' }), ' ']), ' ', el('div', { className: '-mt-28 container duration-500 h-24 max-w-screen-xl mossco-header mx-auto px-0 sticky top-1 transform transition z-50 md:top-0 lg:top-2' }, [' ', ' ', el('nav', { className: 'flex flex-wrap items-center justify-between p-4 sm:py-5 md:px-4 lg:py-0' }, [' ', el('a', { href: '/' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/logo/logo-white-teal.svg', className: 'drop-shadow-xl duration-500 h-9 ml-4 mossco-logo mr-auto scale-125 transform transition lg:h-9' })), ' ', el('button', { className: 'hamburger-menu hover:text-white ml-auto py-2 rounded text-current md:mr-5 lg:hidden', 'data-name': 'nav-toggler', 'data-pg-ia': '{"l":[{"name":"NabMenuToggler","trg":"click","a":{"l":[{"t":"^nav|[data-name=nav-menu]","l":[{"t":"set","p":0,"d":0,"l":{"class.remove":"hidden"}}]},{"t":"#gt# span:nth-of-type(1)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":45,"yPercent":300}}]},{"t":"#gt# span:nth-of-type(2)","l":[{"t":"tween","p":0,"d":0.2,"l":{"autoAlpha":0}}]},{"t":"#gt# span:nth-of-type(3)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":-45,"yPercent":-400}}]}]},"pdef":"true","trev":"true"}]}', 'data-pg-ia-apply': '$nav [data-name=nav-toggler]' }, [' ', el('span', { className: 'bg-primary-NORMAL block h-1 hover:bg-primary-LIGHT my-2 rounded ml-auto w-10 sm:w-12' }), ' ', el('span', { className: 'bg-white block h-1 ml-auto my-2.5 rounded w-6 sm:w-8' }), ' ', el('span', { className: 'bg-primary-NORMAL block h-1 hover: my-2.5 rounded ml-auto w-10 sm:w-12' }), ' ']), ' ', el('a', { href: '#', className: 'bg-primary-NORMAL font-light hidden hover:bg-primary-700 inline-block nav-btn-tablet-mobile px-5 py-2 rounded text-current text-primary-500 uppercase md:inline-block lg:hidden' }, 'Book a Table'), ' ', ' ', el('div', { className: 'bg-Mossco-grey-dark bg-opacity-95 hidden mx-auto pl-4 py-8 rounded space-y-2 text-center w-full md:max-w-md md:mr-0 lg:bg-opacity-0 lg:flex lg:max-w-full lg:space-x-4 lg:space-y-0 lg:text-left lg:w-auto', 'data-name': 'nav-menu', 'data-pg-name': 'Menu Links' }, [' ', ' ', el('div', { className: 'flex flex-col font-normal text-gray-50 lg:flex-row lg:text-sm' }, [' ', ' ', el('div', {}, [' ', el('ul', { ...innerBlocksProps }), ' ']), ' ', ' ']), ' ', el(RichText, { tagName: 'a', href: propOrDefault( props.attributes.mo_nav_button_link.url, 'mo_nav_button_link', 'url' ), className: 'active:bg-primary-DARK bg-primary-NORMAL duration-300 ease-out font-sans hover:bg-primary-LIGHT hover:ring hover:ring-primary-DARK inline-block px-5 py-2 rounded text-base text-white transition uppercase', 'data-pg-name': 'Navigation Button', onClick: function(e) { e.preventDefault(); }, value: propOrDefault( props.attributes.mo_nav_button_text, 'mo_nav_button_text' ), onChange: function(val) { setAttributes( {mo_nav_button_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', ' ']), ' ']), ' ', ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
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
            const blockProps = useBlockProps.save({ className: 'h-24 sm:h-28 sticky top-0 z-50', 'data-pgc-define': 'mossco-navbar-menus', 'data-pgc-define-name': 'Mossco Navbar Menus', 'data-pgc-section': 'Mossco Headers and Footers', 'data-pg-ia-scene': '{"l":[{"name":"burger menu","t":"button","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]},"p":"time","s":"0%"},{"name":"book table button tablet","t":"nav #gt# a:nth-of-type(2)","a":{"l":[{"t":"","l":[{"t":"set","p":0.5,"d":0,"l":{"autoAlpha":0},"e":"Power1.easeOut"},{"t":"tween","p":0.5,"d":0.5,"l":{"autoAlpha":1},"e":"Power1.easeOut"}]}]}}]}' });
            return el('header', { ...blockProps }, [' ', el('div', { className: 'bg-Mossco-grey-background bg-opacity-0 duration-500 false-header h-24 origin-top sticky top-0 transform transition z-50 sm:h-28' }, [' ', el('div', { 'data-empty-placeholder': '' }), ' ']), ' ', el('div', { className: '-mt-28 container duration-500 h-24 max-w-screen-xl mossco-header mx-auto px-0 sticky top-1 transform transition z-50 md:top-0 lg:top-2' }, [' ', ' ', el('nav', { className: 'flex flex-wrap items-center justify-between p-4 sm:py-5 md:px-4 lg:py-0' }, [' ', el('a', { href: '/' }, el('img', { src: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/logo/logo-white-teal.svg', className: 'drop-shadow-xl duration-500 h-9 ml-4 mossco-logo mr-auto scale-125 transform transition lg:h-9' })), ' ', el('button', { className: 'hamburger-menu hover:text-white ml-auto py-2 rounded text-current md:mr-5 lg:hidden', 'data-name': 'nav-toggler', 'data-pg-ia': '{"l":[{"name":"NabMenuToggler","trg":"click","a":{"l":[{"t":"^nav|[data-name=nav-menu]","l":[{"t":"set","p":0,"d":0,"l":{"class.remove":"hidden"}}]},{"t":"#gt# span:nth-of-type(1)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":45,"yPercent":300}}]},{"t":"#gt# span:nth-of-type(2)","l":[{"t":"tween","p":0,"d":0.2,"l":{"autoAlpha":0}}]},{"t":"#gt# span:nth-of-type(3)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":-45,"yPercent":-400}}]}]},"pdef":"true","trev":"true"}]}', 'data-pg-ia-apply': '$nav [data-name=nav-toggler]' }, [' ', el('span', { className: 'bg-primary-NORMAL block h-1 hover:bg-primary-LIGHT my-2 rounded ml-auto w-10 sm:w-12' }), ' ', el('span', { className: 'bg-white block h-1 ml-auto my-2.5 rounded w-6 sm:w-8' }), ' ', el('span', { className: 'bg-primary-NORMAL block h-1 hover: my-2.5 rounded ml-auto w-10 sm:w-12' }), ' ']), ' ', el('a', { href: '#', className: 'bg-primary-NORMAL font-light hidden hover:bg-primary-700 inline-block nav-btn-tablet-mobile px-5 py-2 rounded text-current text-primary-500 uppercase md:inline-block lg:hidden' }, 'Book a Table'), ' ', ' ', el('div', { className: 'bg-Mossco-grey-dark bg-opacity-95 hidden mx-auto pl-4 py-8 rounded space-y-2 text-center w-full md:max-w-md md:mr-0 lg:bg-opacity-0 lg:flex lg:max-w-full lg:space-x-4 lg:space-y-0 lg:text-left lg:w-auto', 'data-name': 'nav-menu', 'data-pg-name': 'Menu Links' }, [' ', ' ', el('div', { className: 'flex flex-col font-normal text-gray-50 lg:flex-row lg:text-sm' }, [' ', ' ', el('div', {}, [' ', el('ul', { className: 'flex flex-col items-center md:text-center lg:flex-row' }, el(InnerBlocks.Content, { allowedBlocks: [ 'mossco-fse/inner-menu-nav-link', 'mossco-fse/inner-menu-nav-item-text' ] })), ' ']), ' ', ' ']), ' ', el(RichText.Content, { tagName: 'a', href: propOrDefault( props.attributes.mo_nav_button_link.url, 'mo_nav_button_link', 'url' ), className: 'active:bg-primary-DARK bg-primary-NORMAL duration-300 ease-out font-sans hover:bg-primary-LIGHT hover:ring hover:ring-primary-DARK inline-block px-5 py-2 rounded text-base text-white transition uppercase', 'data-pg-name': 'Navigation Button', value: propOrDefault( props.attributes.mo_nav_button_text, 'mo_nav_button_text' ) }), ' ', ' ']), ' ']), ' ', ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
