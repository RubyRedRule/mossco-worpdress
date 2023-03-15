
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
    
    const block = registerBlockType( 'mossco-fse/mo-our-brand', {
        apiVersion: 2,
        title: 'Our Brand Section',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M16 2l5 5v14.008a.993.993 0 0 1-.993.992H3.993A1 1 0 0 1 3 21.008V2.992C3 2.444 3.445 2 3.993 2H16zm-5 5v2h2V7h-2zm0 4v6h2v-6h-2z' })]),
        category: 'mo_home_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_our_brand_heading: {
                type: 'text',
                default: `&nbsp;our Brand`,
            },
            mo_our_brand_para: {
                type: 'text',
                default: `The Mossco brand was inspired by its local connection to Moss Street in Dublin 2. &lsquo;Co&rsquo; encompasses the full offering available here &ndash; a full-service Bar, Kitchen &amp; outdoor terrace. Our aim to provide a casual and stylish offering.`,
            },
            mo_our_brand_img_1: {
                type: 'object',
                default: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/our-brand/MossCo%20Cafe-min.jpg', size: '', svg: '', alt: 'image'},
            },
            mo_our_brand_img_2: {
                type: 'object',
                default: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/our-brand/TL%20Townsend%20St_Bar-min.jpg', size: '', svg: '', alt: 'image'},
            },
            mo_our_brand_img_3: {
                type: 'object',
                default: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/our-brand/Travelodge-Pus-Lobby-min.jpg', size: '', svg: '', alt: 'image'},
            }
        },
        example: { attributes: { mo_our_brand_heading: `&nbsp;our Brand`, mo_our_brand_para: `The Mossco brand was inspired by its local connection to Moss Street in Dublin 2. &lsquo;Co&rsquo; encompasses the full offering available here &ndash; a full-service Bar, Kitchen &amp; outdoor terrace. Our aim to provide a casual and stylish offering.`, mo_our_brand_img_1: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/our-brand/MossCo%20Cafe-min.jpg', size: '', svg: '', alt: 'image'}, mo_our_brand_img_2: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/our-brand/TL%20Townsend%20St_Bar-min.jpg', size: '', svg: '', alt: 'image'}, mo_our_brand_img_3: {id: 0, url: (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/home/our-brand/Travelodge-Pus-Lobby-min.jpg', size: '', svg: '', alt: 'image'} } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'border-primary-NORMAL container max-w-screen-xl mx-auto', id: 'home-our-brand', 'data-pg-ia-scene': '{"l":[{"name":"Mossco Our Brand","t":"h3","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%"},{"t":"p","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"}]}' });
            const setAttributes = props.setAttributes; 
            
            props.mo_our_brand_img_1 = useSelect(function( select ) {
                return {
                    mo_our_brand_img_1: props.attributes.mo_our_brand_img_1.id ? select('core').getMedia(props.attributes.mo_our_brand_img_1.id) : undefined
                };
            }, [props.attributes.mo_our_brand_img_1] ).mo_our_brand_img_1;
            

            props.mo_our_brand_img_2 = useSelect(function( select ) {
                return {
                    mo_our_brand_img_2: props.attributes.mo_our_brand_img_2.id ? select('core').getMedia(props.attributes.mo_our_brand_img_2.id) : undefined
                };
            }, [props.attributes.mo_our_brand_img_2] ).mo_our_brand_img_2;
            

            props.mo_our_brand_img_3 = useSelect(function( select ) {
                return {
                    mo_our_brand_img_3: props.attributes.mo_our_brand_img_3.id ? select('core').getMedia(props.attributes.mo_our_brand_img_3.id) : undefined
                };
            }, [props.attributes.mo_our_brand_img_3] ).mo_our_brand_img_3;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', { className: 'container mx-auto our-brand-bg pb-8 pt-16 px-4 md:pt-20' }, [' ', el('h3', { className: 'capitalize font-medium mb-4 text-3xl text-center text-primary-NORMAL', 'data-pg-ia-hide': '' }, el('span', { className: 'uppercase' }, [el('span', { className: 'text-white lg:text-gray-200' }, 'Moss'), el('span', { className: 'text-primary-NORMAL' }, 'co'), el(RichText, { tagName: 'span', className: 'uppercase', value: propOrDefault( props.attributes.mo_our_brand_heading, 'mo_our_brand_heading' ), onChange: function(val) { setAttributes( {mo_our_brand_heading: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] })])), ' ', el(RichText, { tagName: 'p', className: 'font-serif max-w-2xl mx-auto text-base text-center text-white lg:text-gray-200', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_our_brand_para, 'mo_our_brand_para' ), onChange: function(val) { setAttributes( {mo_our_brand_para: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ', el('div', { className: 'border-b-4 border-primary-NORMAL border-solid gap-2 grid grid-cols-1 mx-auto our-brand-img-grid w-full md:grid-cols-2 lg:grid-cols-3', 'data-pg-name': '3 image grid' }, [' ', el('div', { className: 'w-full rounded' }, [' ', props.attributes.mo_our_brand_img_1 && props.attributes.mo_our_brand_img_1.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_our_brand_img_1.svg, 'mo_our_brand_img_1', 'svg' ), {})), props.attributes.mo_our_brand_img_1 && !props.attributes.mo_our_brand_img_1.svg && propOrDefault( props.attributes.mo_our_brand_img_1.url, 'mo_our_brand_img_1', 'url' ) && el('img', { src: propOrDefault( props.attributes.mo_our_brand_img_1.url, 'mo_our_brand_img_1', 'url' ), alt: propOrDefault( props.attributes.mo_our_brand_img_1?.alt, 'mo_our_brand_img_1', 'alt' ), className: (props.attributes.mo_our_brand_img_1.id ? ('wp-image-' + props.attributes.mo_our_brand_img_1.id) : '') }), ' ']), ' ', el('div', { className: 'w-full rounded' }, [' ', props.attributes.mo_our_brand_img_2 && props.attributes.mo_our_brand_img_2.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_our_brand_img_2.svg, 'mo_our_brand_img_2', 'svg' ), {})), props.attributes.mo_our_brand_img_2 && !props.attributes.mo_our_brand_img_2.svg && propOrDefault( props.attributes.mo_our_brand_img_2.url, 'mo_our_brand_img_2', 'url' ) && el('img', { alt: propOrDefault( props.attributes.mo_our_brand_img_2?.alt, 'mo_our_brand_img_2', 'alt' ), src: propOrDefault( props.attributes.mo_our_brand_img_2.url, 'mo_our_brand_img_2', 'url' ), className: (props.attributes.mo_our_brand_img_2.id ? ('wp-image-' + props.attributes.mo_our_brand_img_2.id) : '') }), ' ']), ' ', el('div', { className: 'hidden rounded w-full md:hidden lg:flex' }, [' ', props.attributes.mo_our_brand_img_3 && props.attributes.mo_our_brand_img_3.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_our_brand_img_3.svg, 'mo_our_brand_img_3', 'svg' ), {})), props.attributes.mo_our_brand_img_3 && !props.attributes.mo_our_brand_img_3.svg && propOrDefault( props.attributes.mo_our_brand_img_3.url, 'mo_our_brand_img_3', 'url' ) && el('img', { src: propOrDefault( props.attributes.mo_our_brand_img_3.url, 'mo_our_brand_img_3', 'url' ), alt: propOrDefault( props.attributes.mo_our_brand_img_3?.alt, 'mo_our_brand_img_3', 'alt' ), className: (props.attributes.mo_our_brand_img_3.id ? ('wp-image-' + props.attributes.mo_our_brand_img_3.id) : '') }), ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('mo_our_brand_img_1', setAttributes, props, 'full', true, 'Our Brand Image 1', '' ),
                                        
                        pgMediaImageControl('mo_our_brand_img_2', setAttributes, props, 'full', true, 'Our Brand Image 2', '' ),
                                        
                        pgMediaImageControl('mo_our_brand_img_3', setAttributes, props, 'full', true, 'Our Brand Image 3', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.mo_our_brand_heading,
                                        help: __( '' ),
                                        label: __( 'Our Brand Heading' ),
                                        onChange: function(val) { setAttributes({mo_our_brand_heading: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_our_brand_para,
                                        help: __( '' ),
                                        label: __( 'Our Brand Paragraph Text' ),
                                        onChange: function(val) { setAttributes({mo_our_brand_para: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ className: 'border-primary-NORMAL container max-w-screen-xl mx-auto', id: 'home-our-brand', 'data-pg-ia-scene': '{"l":[{"name":"Mossco Our Brand","t":"h3","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time","s":"30%"},{"t":"p","a":{"l":[{"t":"","l":[{"t":"set","p":0,"d":0,"l":{"autoAlpha":0,"y":"100%"},"e":"Power1.easeOut"},{"t":"tween","p":0,"d":0.5,"l":{"autoAlpha":1,"y":"0%"},"e":"Power1.easeOut"}]}]},"p":"time"}]}' });
            return el('section', { ...blockProps }, [' ', el('div', { className: 'container mx-auto our-brand-bg pb-8 pt-16 px-4 md:pt-20' }, [' ', el('h3', { className: 'capitalize font-medium mb-4 text-3xl text-center text-primary-NORMAL', 'data-pg-ia-hide': '' }, el('span', { className: 'uppercase' }, [el('span', { className: 'text-white lg:text-gray-200' }, 'Moss'), el('span', { className: 'text-primary-NORMAL' }, 'co'), el(RichText.Content, { tagName: 'span', className: 'uppercase', value: propOrDefault( props.attributes.mo_our_brand_heading, 'mo_our_brand_heading' ) })])), ' ', el(RichText.Content, { tagName: 'p', className: 'font-serif max-w-2xl mx-auto text-base text-center text-white lg:text-gray-200', 'data-pg-ia-hide': '', value: propOrDefault( props.attributes.mo_our_brand_para, 'mo_our_brand_para' ) }), ' ']), ' ', el('div', { className: 'border-b-4 border-primary-NORMAL border-solid gap-2 grid grid-cols-1 mx-auto our-brand-img-grid w-full md:grid-cols-2 lg:grid-cols-3', 'data-pg-name': '3 image grid' }, [' ', el('div', { className: 'w-full rounded' }, [' ', props.attributes.mo_our_brand_img_1 && props.attributes.mo_our_brand_img_1.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_our_brand_img_1.svg, 'mo_our_brand_img_1', 'svg' ), {})), props.attributes.mo_our_brand_img_1 && !props.attributes.mo_our_brand_img_1.svg && propOrDefault( props.attributes.mo_our_brand_img_1.url, 'mo_our_brand_img_1', 'url' ) && el('img', { src: propOrDefault( props.attributes.mo_our_brand_img_1.url, 'mo_our_brand_img_1', 'url' ), alt: propOrDefault( props.attributes.mo_our_brand_img_1?.alt, 'mo_our_brand_img_1', 'alt' ), className: (props.attributes.mo_our_brand_img_1.id ? ('wp-image-' + props.attributes.mo_our_brand_img_1.id) : '') }), ' ']), ' ', el('div', { className: 'w-full rounded' }, [' ', props.attributes.mo_our_brand_img_2 && props.attributes.mo_our_brand_img_2.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_our_brand_img_2.svg, 'mo_our_brand_img_2', 'svg' ), {})), props.attributes.mo_our_brand_img_2 && !props.attributes.mo_our_brand_img_2.svg && propOrDefault( props.attributes.mo_our_brand_img_2.url, 'mo_our_brand_img_2', 'url' ) && el('img', { alt: propOrDefault( props.attributes.mo_our_brand_img_2?.alt, 'mo_our_brand_img_2', 'alt' ), src: propOrDefault( props.attributes.mo_our_brand_img_2.url, 'mo_our_brand_img_2', 'url' ), className: (props.attributes.mo_our_brand_img_2.id ? ('wp-image-' + props.attributes.mo_our_brand_img_2.id) : '') }), ' ']), ' ', el('div', { className: 'hidden rounded w-full md:hidden lg:flex' }, [' ', props.attributes.mo_our_brand_img_3 && props.attributes.mo_our_brand_img_3.svg && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_our_brand_img_3.svg, 'mo_our_brand_img_3', 'svg' ), {})), props.attributes.mo_our_brand_img_3 && !props.attributes.mo_our_brand_img_3.svg && propOrDefault( props.attributes.mo_our_brand_img_3.url, 'mo_our_brand_img_3', 'url' ) && el('img', { src: propOrDefault( props.attributes.mo_our_brand_img_3.url, 'mo_our_brand_img_3', 'url' ), alt: propOrDefault( props.attributes.mo_our_brand_img_3?.alt, 'mo_our_brand_img_3', 'alt' ), className: (props.attributes.mo_our_brand_img_3.id ? ('wp-image-' + props.attributes.mo_our_brand_img_3.id) : '') }), ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
