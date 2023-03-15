
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
    
    const block = registerBlockType( 'mossco-fse/mo-newsletter-block', {
        apiVersion: 2,
        title: 'Newsletter Block',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M22 13.341A6 6 0 0 0 14.341 21H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v9.341zm-9.94-1.658L5.648 6.238 4.353 7.762l7.72 6.555 7.581-6.56-1.308-1.513-6.285 5.439zM21 18h3v2h-3v3h-2v-3h-3v-2h3v-3h2v3z' })]),
        category: 'mo_home_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            newsletter_header: {
                type: 'text',
                default: `Newsletter`,
            }
        },
        example: { attributes: { newsletter_header: `Newsletter` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ id: 'home-newsletter', className: 'newsletter-bg py-14 text-center text-gray-800 md:py-16', 'data-pg-ia-scene': '{"l":[{"name":"Mossco Our Brand","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%","rev":"true","t":"h2"},{"name":"Mossco brand text","t":"p","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%","rev":"true"}]}', 'data-pgc': 'mossco.newsletter', 'data-pgc-no-update': null });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: 'flex flex-wrap justify-center' }, [' ', el('div', { className: 'flex-basis grow-0 px-3 shrink-0 w-full md:px-4 lg:w-7/12' }, [' ', el(RichText, { tagName: 'h2', className: 'font-medium font-sans mb-6 text-3xl text-center text-primary-NORMAL uppercase', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.newsletter_header, 'newsletter_header' ), onChange: function(val) { setAttributes( {newsletter_header: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el('p', { className: 'font-serif mb-12 mx-10 text-center text-gray-200 md:text-gray-200 lg:mb-10 lg:text-gray-200', 'data-pg-ia-hide': '' }, 'Join our mailing list for exclusive offers and our latest news.'), ' ', el('div', { className: 'content-center flex flex-col items-center justify-center md:flex md:flex-row md:mx-4 xl:mx-10 2xl:mx-32' }, [' ', el('input', { type: 'text', className: 'bg-clip-padding bg-white block border border-gray-300 border-solid ease-in-out focus:bg-white focus:border-blue-600 focus:outline-none focus:text-gray-700 font-normal font-serif form-control m-auto pb-2 pt-3 px-4 rounded text-center text-gray-700 text-xl transition w-80 md:mb-0 md:mr-2 md:text-left md:w-full', placeholder: 'Enter your email' }), ' ', el('button', { type: 'submit', className: 'active:bg-primary-DARK bg-primary-NORMAL drop-shadow-md duration-300 ease-in-out hover:bg-primary-LIGHT hover:ring-2 hover:ring-inset hover:ring-primary-DARK inline-block justify-center justify-self-center leading-snug mt-6 mx-auto px-7 py-3 rounded shadow-md text-lg text-white transition uppercase md:ml-2', 'data-mdb-ripple': 'true', 'data-mdb-ripple-color': 'light' }, [' Subscribe', ' ']), ' ']), ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.newsletter_header,
                                        help: __( '' ),
                                        label: __( 'Newletter Heading ' ),
                                        onChange: function(val) { setAttributes({newsletter_header: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ id: 'home-newsletter', className: 'newsletter-bg py-14 text-center text-gray-800 md:py-16', 'data-pg-ia-scene': '{"l":[{"name":"Mossco Our Brand","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%","rev":"true","t":"h2"},{"name":"Mossco brand text","t":"p","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%","rev":"true"}]}', 'data-pgc': 'mossco.newsletter', 'data-pgc-no-update': null });
            return el('section', { ...blockProps }, [' ', el('div', { className: 'flex flex-wrap justify-center' }, [' ', el('div', { className: 'flex-basis grow-0 px-3 shrink-0 w-full md:px-4 lg:w-7/12' }, [' ', el(RichText.Content, { tagName: 'h2', className: 'font-medium font-sans mb-6 text-3xl text-center text-primary-NORMAL uppercase', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.newsletter_header, 'newsletter_header' ) }), ' ', el('p', { className: 'font-serif mb-12 mx-10 text-center text-gray-200 md:text-gray-200 lg:mb-10 lg:text-gray-200', 'data-pg-ia-hide': '' }, 'Join our mailing list for exclusive offers and our latest news.'), ' ', el('div', { className: 'content-center flex flex-col items-center justify-center md:flex md:flex-row md:mx-4 xl:mx-10 2xl:mx-32' }, [' ', el('input', { type: 'text', className: 'bg-clip-padding bg-white block border border-gray-300 border-solid ease-in-out focus:bg-white focus:border-blue-600 focus:outline-none focus:text-gray-700 font-normal font-serif form-control m-auto pb-2 pt-3 px-4 rounded text-center text-gray-700 text-xl transition w-80 md:mb-0 md:mr-2 md:text-left md:w-full', placeholder: 'Enter your email' }), ' ', el('button', { type: 'submit', className: 'active:bg-primary-DARK bg-primary-NORMAL drop-shadow-md duration-300 ease-in-out hover:bg-primary-LIGHT hover:ring-2 hover:ring-inset hover:ring-primary-DARK inline-block justify-center justify-self-center leading-snug mt-6 mx-auto px-7 py-3 rounded shadow-md text-lg text-white transition uppercase md:ml-2', 'data-mdb-ripple': 'true', 'data-mdb-ripple-color': 'light' }, [' Subscribe', ' ']), ' ']), ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
