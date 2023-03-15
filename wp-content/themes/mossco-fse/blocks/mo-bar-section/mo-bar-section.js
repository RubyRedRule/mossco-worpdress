
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
    
    const block = registerBlockType( 'mossco-fse/mo-bar-section', {
        apiVersion: 2,
        title: 'Mossco Bar Section',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M11 3v18H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7zm10 10v7a1 1 0 0 1-1 1h-7v-8h8zM20 3a1 1 0 0 1 1 1v7h-8V3h7z' })]),
        category: 'mo_home_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_bar_section_img_1: {
                type: 'object',
                default: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/bar/travelodge-lounge-2-min.jpg', size: '', svg: '', alt: null},
            },
            mo_heading_bar: {
                type: 'text',
                default: `&nbsp;Bar`,
            },
            mo_bar_section_text: {
                type: 'text',
                default: `Casual but stylish dining can be found within Mossco Restaurant - a perfect combination for our food and drink offering. With ample cosy seating and chic interiors, Mossco Restaurant is the place to relax and dine in Dublin 2.`,
            },
            mo_bar_section_img_2: {
                type: 'object',
                default: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/bar/travelodge-mossco-bar-min.jpg', size: '', svg: '', alt: null},
            }
        },
        example: { attributes: { mo_bar_section_img_1: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/bar/travelodge-lounge-2-min.jpg', size: '', svg: '', alt: null}, mo_heading_bar: `&nbsp;Bar`, mo_bar_section_text: `Casual but stylish dining can be found within Mossco Restaurant - a perfect combination for our food and drink offering. With ample cosy seating and chic interiors, Mossco Restaurant is the place to relax and dine in Dublin 2.`, mo_bar_section_img_2: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/bar/travelodge-mossco-bar-min.jpg', size: '', svg: '', alt: null} } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ id: 'home-bar', 'data-pg-ia-scene': '{"l":[{"t":"h3","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%","rev":"true"},{"t":"p","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%","rev":"true"}]}' });
            const setAttributes = props.setAttributes; 
            
            props.mo_bar_section_img_1 = useSelect(function( select ) {
                return {
                    mo_bar_section_img_1: props.attributes.mo_bar_section_img_1.id ? select('core').getMedia(props.attributes.mo_bar_section_img_1.id) : undefined
                };
            }, [props.attributes.mo_bar_section_img_1] ).mo_bar_section_img_1;
            

            props.mo_bar_section_img_2 = useSelect(function( select ) {
                return {
                    mo_bar_section_img_2: props.attributes.mo_bar_section_img_2.id ? select('core').getMedia(props.attributes.mo_bar_section_img_2.id) : undefined
                };
            }, [props.attributes.mo_bar_section_img_2] ).mo_bar_section_img_2;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: 'border-Mossco-grey-dark border-t-4 container gap-3 grid grid-cols-1 max-w-screen-xl mossco-bar-grid mx-auto md:grid-cols-4 md:grid-rows-2' }, [' ', el('div', { className: 'col-span-2 row-span-3 md:row-span-2' }, [' ', props.attributes.mo_bar_section_img_1 && props.attributes.mo_bar_section_img_1.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_bar_section_img_1.svg, 'mo_bar_section_img_1', 'svg' ), {})), props.attributes.mo_bar_section_img_1 && !props.attributes.mo_bar_section_img_1.svg && propOrDefault( props.attributes.mo_bar_section_img_1.url, 'mo_bar_section_img_1', 'url' ) && el('img', { src: propOrDefault( props.attributes.mo_bar_section_img_1.url, 'mo_bar_section_img_1', 'url' ), alt: propOrDefault( props.attributes.mo_bar_section_img_1?.alt, 'mo_bar_section_img_1', 'alt' ), className: (props.attributes.mo_bar_section_img_1.id ? ('wp-image-' + props.attributes.mo_bar_section_img_1.id) : '') }), ' ']), ' ', el('div', { className: 'col-span-2 md:my-auto md:pl-2 md:pr-12 my-10 px-8 xl:pr-20' }, [' ', el('h3', { className: 'capitalize font-medium text-3xl text-left text-primary-NORMAL md:pb-3', 'data-pg-ia-hide': '' }, el('span', { className: 'uppercase' }, [el('span', { className: 'text-white lg:text-gray-200' }, 'Moss'), el('span', { className: 'text-primary-NORMAL' }, 'co'), el(RichText, { tagName: 'span', className: 'uppercase', value: propOrDefault( props.attributes.mo_heading_bar, 'mo_heading_bar' ), onChange: function(val) { setAttributes( {mo_heading_bar: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] })])), ' ', el(RichText, { tagName: 'p', className: 'font-serif text-base text-gray-200 lg:text-gray-200', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_bar_section_text, 'mo_bar_section_text' ), onChange: function(val) { setAttributes( {mo_bar_section_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ', el('div', { className: 'col-span-2 h-full object-center object-cover row-span-2 w-full md:row-span-1' }, [' ', props.attributes.mo_bar_section_img_2 && props.attributes.mo_bar_section_img_2.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_bar_section_img_2.svg, 'mo_bar_section_img_2', 'svg' ), {})), props.attributes.mo_bar_section_img_2 && !props.attributes.mo_bar_section_img_2.svg && propOrDefault( props.attributes.mo_bar_section_img_2.url, 'mo_bar_section_img_2', 'url' ) && el('img', { src: propOrDefault( props.attributes.mo_bar_section_img_2.url, 'mo_bar_section_img_2', 'url' ), alt: propOrDefault( props.attributes.mo_bar_section_img_2?.alt, 'mo_bar_section_img_2', 'alt' ), className: (props.attributes.mo_bar_section_img_2.id ? ('wp-image-' + props.attributes.mo_bar_section_img_2.id) : '') }), ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('mo_bar_section_img_1', setAttributes, props, 'full', true, 'Bar Section image 1', '' ),
                                        
                        pgMediaImageControl('mo_bar_section_img_2', setAttributes, props, 'full', true, 'Bar Section image 2', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.mo_heading_bar,
                                        help: __( '' ),
                                        label: __( 'Bar Heading Text' ),
                                        onChange: function(val) { setAttributes({mo_heading_bar: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_bar_section_text,
                                        help: __( '' ),
                                        label: __( 'Bar Section Paragraph' ),
                                        onChange: function(val) { setAttributes({mo_bar_section_text: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ id: 'home-bar', 'data-pg-ia-scene': '{"l":[{"t":"h3","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%","rev":"true"},{"t":"p","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%","rev":"true"}]}' });
            return el('section', { ...blockProps }, [' ', el('div', { className: 'border-Mossco-grey-dark border-t-4 container gap-3 grid grid-cols-1 max-w-screen-xl mossco-bar-grid mx-auto md:grid-cols-4 md:grid-rows-2' }, [' ', el('div', { className: 'col-span-2 row-span-3 md:row-span-2' }, [' ', props.attributes.mo_bar_section_img_1 && props.attributes.mo_bar_section_img_1.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_bar_section_img_1.svg, 'mo_bar_section_img_1', 'svg' ), {})), props.attributes.mo_bar_section_img_1 && !props.attributes.mo_bar_section_img_1.svg && propOrDefault( props.attributes.mo_bar_section_img_1.url, 'mo_bar_section_img_1', 'url' ) && el('img', { src: propOrDefault( props.attributes.mo_bar_section_img_1.url, 'mo_bar_section_img_1', 'url' ), alt: propOrDefault( props.attributes.mo_bar_section_img_1?.alt, 'mo_bar_section_img_1', 'alt' ), className: (props.attributes.mo_bar_section_img_1.id ? ('wp-image-' + props.attributes.mo_bar_section_img_1.id) : '') }), ' ']), ' ', el('div', { className: 'col-span-2 md:my-auto md:pl-2 md:pr-12 my-10 px-8 xl:pr-20' }, [' ', el('h3', { className: 'capitalize font-medium text-3xl text-left text-primary-NORMAL md:pb-3', 'data-pg-ia-hide': '' }, el('span', { className: 'uppercase' }, [el('span', { className: 'text-white lg:text-gray-200' }, 'Moss'), el('span', { className: 'text-primary-NORMAL' }, 'co'), el(RichText.Content, { tagName: 'span', className: 'uppercase', value: propOrDefault( props.attributes.mo_heading_bar, 'mo_heading_bar' ) })])), ' ', el(RichText.Content, { tagName: 'p', className: 'font-serif text-base text-gray-200 lg:text-gray-200', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_bar_section_text, 'mo_bar_section_text' ) }), ' ']), ' ', el('div', { className: 'col-span-2 h-full object-center object-cover row-span-2 w-full md:row-span-1' }, [' ', props.attributes.mo_bar_section_img_2 && props.attributes.mo_bar_section_img_2.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_bar_section_img_2.svg, 'mo_bar_section_img_2', 'svg' ), {})), props.attributes.mo_bar_section_img_2 && !props.attributes.mo_bar_section_img_2.svg && propOrDefault( props.attributes.mo_bar_section_img_2.url, 'mo_bar_section_img_2', 'url' ) && el('img', { src: propOrDefault( props.attributes.mo_bar_section_img_2.url, 'mo_bar_section_img_2', 'url' ), alt: propOrDefault( props.attributes.mo_bar_section_img_2?.alt, 'mo_bar_section_img_2', 'alt' ), className: (props.attributes.mo_bar_section_img_2.id ? ('wp-image-' + props.attributes.mo_bar_section_img_2.id) : '') }), ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
