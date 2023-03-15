
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
    
    const block = registerBlockType( 'mossco-fse/mo-location-map-section', {
        apiVersion: 2,
        title: 'Location & Map Section',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M18.364 17.364L12 23.728l-6.364-6.364a9 9 0 1 1 12.728 0zM12 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z' })]),
        category: 'mo_home_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_location_address_h4: {
                type: 'text',
                default: `Travelodge Plus <p class="font-serif text-base">44 Townsend Street</p> <p class="font-serif text-base">Dublin Docklands</p> <p class="font-serif text-base">Dublin</p> <p class="font-serif text-base">D02 DY01</p>`,
            },
            mo_location_address_1: {
                type: 'text',
                default: `44 Townsend Street`,
            },
            mo_location_address_2: {
                type: 'text',
                default: `Dublin Docklands`,
            },
            mo_location_address_3: {
                type: 'text',
                default: `Dublin`,
            },
            mo_location_address_4: {
                type: 'text',
                default: `D02 DY01`,
            },
            mo_phone: {
                type: 'text',
                default: `<a href="tel:+35315259500" class="lg:text-gray-200">(01) 525 9500</a>`,
            },
            mo_contact_email_text: {
                type: 'text',
                default: `<a href="mailto:info@travelodgeplus.ie" class="lg:text-gray-200">info@travelodgeplus.ie</a>`,
            },
            mo_contact_email_link: {
                type: 'object',
                default: {post_id: 0, url: 'mailto:info@travelodgeplus.ie', title: '', 'post_type': null},
            }
        },
        example: { attributes: { mo_location_address_h4: `Travelodge Plus <p class="font-serif text-base">44 Townsend Street</p> <p class="font-serif text-base">Dublin Docklands</p> <p class="font-serif text-base">Dublin</p> <p class="font-serif text-base">D02 DY01</p>`, mo_location_address_1: `44 Townsend Street`, mo_location_address_2: `Dublin Docklands`, mo_location_address_3: `Dublin`, mo_location_address_4: `D02 DY01`, mo_phone: `<a href="tel:+35315259500" class="lg:text-gray-200">(01) 525 9500</a>`, mo_contact_email_text: `<a href="mailto:info@travelodgeplus.ie" class="lg:text-gray-200">info@travelodgeplus.ie</a>`, mo_contact_email_link: {post_id: 0, url: 'mailto:info@travelodgeplus.ie', title: '', 'post_type': null} } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ id: 'details-map', className: 'border-Mossco-grey-dark border-b-4 border-t-4', 'data-pgc': 'mossco-location-map', 'data-pgc-no-update': null });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', {}, [' ', el('div', { className: 'gap-4 grid grid-cols-3 grid-rows-1 md:gap-2 md:grid-cols-2 lg:gap-y-0 lg:grid-cols-4' }, [' ', el('div', { className: 'col-span-1 left-grid-graphic maps-bg my-4 row-span-1 md:col-span-1 md:my-6', style: { backgroundImage: 'url(\'' + (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/graphics/contact-art-graphic.svg\')',backgroundRepeat: 'no-repeat',backgroundPosition: 'center center',backgroundSize: 'contain' } }), ' ', el('div', { className: 'col-span-2 my-auto pb-7 pt-10 row-span-1 md:col-span-1 md:pb-6 md:pt-8' }, [' ', el('div', { className: 'grid grid-cols-8 grid-rows-1 mx-auto md:py-6' }, [' ', el('div', { className: 'col-span-1 grid place-items-center' }, [' ', el('svg', { id: 'Layer_2', 'data-name': 'Layer 2', xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 21 27.95', className: 'fill-primary-NORMAL w-6' }, [' ', el('defs', {}, [' ', el('style', {}), ' ']), ' ', el('g', { id: 'Layer_1-2', 'data-name': 'Layer 1' }, [' ', el('g', { className: 'cls-2' }, [' ', el('g', { className: 'cls-2' }, [' ', el('path', { className: 'cls-1', d: 'm20.02,14.57c-.66,1.59-1.53,3.22-2.62,4.89-1.09,1.68-2.07,3.12-2.93,4.32-.86,1.2-1.74,2.37-2.65,3.5-.36.44-.8.66-1.31.66s-.95-.22-1.31-.66c-1.28-1.57-2.52-3.2-3.72-4.89s-2.42-3.74-3.64-6.12c-1.22-2.39-1.83-4.31-1.83-5.77,0-2.92,1.02-5.4,3.06-7.44C5.1,1.02,7.58,0,10.5,0s5.4,1.02,7.44,3.06c2.04,2.04,3.06,4.52,3.06,7.44,0,1.13-.33,2.49-.98,4.07ZM1.75,10.5c0,.88.31,2.02.93,3.45.55,1.35,1.33,2.86,2.35,4.54,1.46,2.33,3.28,4.89,5.47,7.66,2.19-2.77,4.01-5.32,5.47-7.66,1.02-1.68,1.8-3.19,2.35-4.54.62-1.42.93-2.57.93-3.45,0-2.41-.86-4.47-2.57-6.18-1.71-1.71-3.77-2.57-6.18-2.57s-4.47.86-6.18,2.57c-1.71,1.71-2.57,3.77-2.57,6.18Zm8.75,4.38c-1.2,0-2.23-.43-3.09-1.29-.86-.86-1.29-1.89-1.29-3.09s.43-2.23,1.29-3.09c.86-.86,1.89-1.29,3.09-1.29s2.23.43,3.09,1.29c.86.86,1.29,1.89,1.29,3.09s-.43,2.23-1.29,3.09-1.89,1.29-3.09,1.29Zm2.62-4.38c0-.73-.26-1.35-.77-1.86-.51-.51-1.13-.77-1.86-.77s-1.35.26-1.86.77c-.51.51-.77,1.13-.77,1.86s.25,1.35.77,1.86c.51.51,1.13.77,1.86.77s1.35-.25,1.86-.77.77-1.13.77-1.86Z' }), ' ']), ' ']), ' ']), ' ']), ' ']), ' ', el('div', { className: 'col-span-7' }, [' ', el('h4', { className: 'font-sans pl-2 text-white text-xl uppercase' }, [el('span', { className: 'lg:text-gray-200' }, 'Moss'), el('span', { className: 'text-primary-NORMAL' }, 'co')]), ' ']), ' ', el('div', { className: 'col-span-1 grid place-items-center' }), ' ', el('div', { className: 'col-span-7' }, [' ', el(RichText, { tagName: 'h4', className: 'font-sans pl-2 pt-0 text-white text-xl lg:text-gray-200', value: propOrDefault( props.attributes.mo_location_address_h4, 'mo_location_address_h4' ), onChange: function(val) { setAttributes( {mo_location_address_h4: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ', el('div', { className: 'col-span-1 grid place-items-center pt-6' }, [' ', el('svg', { id: 'Layer_2', 'xml': '', version: '1.0', encoding: 'UTF-8', 'data-name': 'Layer 2', xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 511.24 448', className: 'fill-primary-NORMAL w-6', 'preserveAspectRatio': '' }, [' ', el('g', { id: 'Layer_1-2', 'data-name': 'Layer 1' }, [' ', el('path', { d: 'm256,208c-44.13,0-80,35.88-80,80s35.88,80,80,80,80-35.88,80-80-35.9-80-80-80Zm0,128c-26.5,0-48-21.5-48-48s21.5-48,48-48,48,21.5,48,48-21.5,48-48,48Zm244.2-249.7C431.7,31.25,344.8,0,256,0S80.25,31.25,11.75,86.3C4.25,92.43-.13,101.68,0,111.3v64.7c0,8.84,7.16,16,16,16h64c8.84,0,16-7.2,16-16s-7.16-16-16-16h-48l-.25-48.9c63.63-50.97,142.75-78.85,224.25-79.1,81.5.12,160.5,28.12,223.1,79.25v48.75h-47.1c-8.8,0-16,7.2-16,16s7.2,16,16,16h63.1c8.84,0,16-7.16,16-16v-64.7c1-9.7-3.4-18.9-10.9-25Zm-129.8,73.9c-10.53-18.42-29.57-29.9-50.5-31.57,0-.23.1-.43.1-.63v-32c0-8.84-7.16-16-16-16s-16,7.16-16,16v32h-64v-32c0-8.84-7.16-16-16-16s-16,7.16-16,16v32c0,.24.13.44.14.67-20.95,1.69-39.98,13.14-50.51,31.58l-101.2,177.1c-5.53,9.67-8.43,20.62-8.43,31.76v14.89c0,35.2,28.8,64,64,64h319.1c35.2,0,64-28.8,64-64v-14.94c0-11.14-2.91-22.08-8.44-31.76l-100.26-177.1Zm76.7,223.8c0,17.67-14.33,32-32,32H96c-17.67,0-32-14.33-32-32v-15c0-5.57,1.45-11.04,4.22-15.88l101.2-176.1c5.68-10.82,16.28-17.02,27.78-17.02h117.7c11.46,0,22.04,6.14,27.73,16.09l101.2,177c2.76,4.83,4.22,10.31,4.22,15.88v15.03h-.95Z' }), ' ']), ' ']), ' ']), ' ', el('div', { className: 'col-span-7 pt-6' }, [' ', el(RichText, { tagName: 'h4', className: 'pl-1.5 font-serif text-base uppercase text-white', value: propOrDefault( props.attributes.mo_phone, 'mo_phone' ), onChange: function(val) { setAttributes( {mo_phone: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ', el('div', { className: 'col-span-1 grid place-items-center pt-6' }, [' ', el('svg', { id: 'Layer_2', 'data-name': 'Layer 2', xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 512 384', 'preserveAspectRatio': '', className: 'fill-primary-NORMAL text-base w-6' }, [' ', el('g', { id: 'Layer_1-2', 'data-name': 'Layer 1' }, [' ', el('path', { d: 'm0,64C0,28.65,28.65,0,64,0h384c35.3,0,64,28.65,64,64v256c0,35.3-28.7,64-64,64H64c-35.35,0-64-28.7-64-64V64Zm32,0v39.9l195.6,143.4c16.9,12.4,39.9,12.4,56.8,0l195.6-143.4v-39.9c0-17.7-14.3-32-32-32H63.1c-16.77,0-32,14.3-32,32h.9Zm0,79.6v176.4c0,17.7,14.33,32,32,32h384c17.7,0,32-14.3,32-32v-176.4l-176.7,129.5c-28.2,20.7-66.4,20.7-94.6,0L32,143.6Z' }), ' ']), ' ']), ' ']), ' ', el('div', { className: 'col-span-7 pt-6' }, [' ', el(RichText, { tagName: 'h4', className: 'pl-2 font-serif text-base lowercase text-white', value: propOrDefault( props.attributes.mo_contact_email_text, 'mo_contact_email_text' ), onChange: function(val) { setAttributes( {mo_contact_email_text: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ']), ' ']), ' ']), ' ', el('div', { className: 'col-span-3 row-span-1 w-auto md:col-span-2' }, [' ', el('div', { id: 'map-box', className: 'h-96 map-box py-56 w-auto' }, [' ', el('script', { 'async': '', src: 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDCjQbOAcZR002cGDTl_hchKl_Oo9vI33U&callback=initMap', 'data-pg-name': 'Google Maps' }), ' ', el('link', { rel: 'icon', type: 'image/svg+xml', href: 'favicon.svg' }), ' ', el('link', { rel: 'icon', type: 'image/png', href: 'favicon.png' }), ' ']), ' ']), ' ']), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.mo_location_address_h4,
                                        help: __( '' ),
                                        label: __( 'Address Heading Text' ),
                                        onChange: function(val) { setAttributes({mo_location_address_h4: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_location_address_1,
                                        help: __( '' ),
                                        label: __( 'Location Address line 1' ),
                                        onChange: function(val) { setAttributes({mo_location_address_1: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_location_address_2,
                                        help: __( '' ),
                                        label: __( 'Location Address line 2' ),
                                        onChange: function(val) { setAttributes({mo_location_address_2: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_location_address_3,
                                        help: __( '' ),
                                        label: __( 'Location Address line 3' ),
                                        onChange: function(val) { setAttributes({mo_location_address_3: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_location_address_4,
                                        help: __( '' ),
                                        label: __( 'Location Address line 4' ),
                                        onChange: function(val) { setAttributes({mo_location_address_4: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_phone,
                                        help: __( '' ),
                                        label: __( 'Phone Details' ),
                                        onChange: function(val) { setAttributes({mo_phone: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.mo_contact_email_text,
                                        help: __( '' ),
                                        label: __( 'Contact Email Address' ),
                                        onChange: function(val) { setAttributes({mo_contact_email_text: val}) },
                                        type: 'text'
                                    }),
                                    pgUrlControl('mo_contact_email_link', setAttributes, props, 'mailto: Email Address', '', null ),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ id: 'details-map', className: 'border-Mossco-grey-dark border-b-4 border-t-4', 'data-pgc': 'mossco-location-map', 'data-pgc-no-update': null });
            return el('section', { ...blockProps }, [' ', el('div', {}, [' ', el('div', { className: 'gap-4 grid grid-cols-3 grid-rows-1 md:gap-2 md:grid-cols-2 lg:gap-y-0 lg:grid-cols-4' }, [' ', el('div', { className: 'col-span-1 left-grid-graphic maps-bg my-4 row-span-1 md:col-span-1 md:my-6', style: { backgroundImage: 'url(\'' + (pg_project_data_mossco_fse ? pg_project_data_mossco_fse.url : '') + 'assets/images/graphics/contact-art-graphic.svg\')',backgroundRepeat: 'no-repeat',backgroundPosition: 'center center',backgroundSize: 'contain' } }), ' ', el('div', { className: 'col-span-2 my-auto pb-7 pt-10 row-span-1 md:col-span-1 md:pb-6 md:pt-8' }, [' ', el('div', { className: 'grid grid-cols-8 grid-rows-1 mx-auto md:py-6' }, [' ', el('div', { className: 'col-span-1 grid place-items-center' }, [' ', el('svg', { id: 'Layer_2', 'data-name': 'Layer 2', xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 21 27.95', className: 'fill-primary-NORMAL w-6' }, [' ', el('defs', {}, [' ', el('style', {}), ' ']), ' ', el('g', { id: 'Layer_1-2', 'data-name': 'Layer 1' }, [' ', el('g', { className: 'cls-2' }, [' ', el('g', { className: 'cls-2' }, [' ', el('path', { className: 'cls-1', d: 'm20.02,14.57c-.66,1.59-1.53,3.22-2.62,4.89-1.09,1.68-2.07,3.12-2.93,4.32-.86,1.2-1.74,2.37-2.65,3.5-.36.44-.8.66-1.31.66s-.95-.22-1.31-.66c-1.28-1.57-2.52-3.2-3.72-4.89s-2.42-3.74-3.64-6.12c-1.22-2.39-1.83-4.31-1.83-5.77,0-2.92,1.02-5.4,3.06-7.44C5.1,1.02,7.58,0,10.5,0s5.4,1.02,7.44,3.06c2.04,2.04,3.06,4.52,3.06,7.44,0,1.13-.33,2.49-.98,4.07ZM1.75,10.5c0,.88.31,2.02.93,3.45.55,1.35,1.33,2.86,2.35,4.54,1.46,2.33,3.28,4.89,5.47,7.66,2.19-2.77,4.01-5.32,5.47-7.66,1.02-1.68,1.8-3.19,2.35-4.54.62-1.42.93-2.57.93-3.45,0-2.41-.86-4.47-2.57-6.18-1.71-1.71-3.77-2.57-6.18-2.57s-4.47.86-6.18,2.57c-1.71,1.71-2.57,3.77-2.57,6.18Zm8.75,4.38c-1.2,0-2.23-.43-3.09-1.29-.86-.86-1.29-1.89-1.29-3.09s.43-2.23,1.29-3.09c.86-.86,1.89-1.29,3.09-1.29s2.23.43,3.09,1.29c.86.86,1.29,1.89,1.29,3.09s-.43,2.23-1.29,3.09-1.89,1.29-3.09,1.29Zm2.62-4.38c0-.73-.26-1.35-.77-1.86-.51-.51-1.13-.77-1.86-.77s-1.35.26-1.86.77c-.51.51-.77,1.13-.77,1.86s.25,1.35.77,1.86c.51.51,1.13.77,1.86.77s1.35-.25,1.86-.77.77-1.13.77-1.86Z' }), ' ']), ' ']), ' ']), ' ']), ' ']), ' ', el('div', { className: 'col-span-7' }, [' ', el('h4', { className: 'font-sans pl-2 text-white text-xl uppercase' }, [el('span', { className: 'lg:text-gray-200' }, 'Moss'), el('span', { className: 'text-primary-NORMAL' }, 'co')]), ' ']), ' ', el('div', { className: 'col-span-1 grid place-items-center' }), ' ', el('div', { className: 'col-span-7' }, [' ', el(RichText.Content, { tagName: 'h4', className: 'font-sans pl-2 pt-0 text-white text-xl lg:text-gray-200', value: propOrDefault( props.attributes.mo_location_address_h4, 'mo_location_address_h4' ) }), ' ']), ' ', el('div', { className: 'col-span-1 grid place-items-center pt-6' }, [' ', el('svg', { id: 'Layer_2', 'xml': '', version: '1.0', encoding: 'UTF-8', 'data-name': 'Layer 2', xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 511.24 448', className: 'fill-primary-NORMAL w-6', 'preserveAspectRatio': '' }, [' ', el('g', { id: 'Layer_1-2', 'data-name': 'Layer 1' }, [' ', el('path', { d: 'm256,208c-44.13,0-80,35.88-80,80s35.88,80,80,80,80-35.88,80-80-35.9-80-80-80Zm0,128c-26.5,0-48-21.5-48-48s21.5-48,48-48,48,21.5,48,48-21.5,48-48,48Zm244.2-249.7C431.7,31.25,344.8,0,256,0S80.25,31.25,11.75,86.3C4.25,92.43-.13,101.68,0,111.3v64.7c0,8.84,7.16,16,16,16h64c8.84,0,16-7.2,16-16s-7.16-16-16-16h-48l-.25-48.9c63.63-50.97,142.75-78.85,224.25-79.1,81.5.12,160.5,28.12,223.1,79.25v48.75h-47.1c-8.8,0-16,7.2-16,16s7.2,16,16,16h63.1c8.84,0,16-7.16,16-16v-64.7c1-9.7-3.4-18.9-10.9-25Zm-129.8,73.9c-10.53-18.42-29.57-29.9-50.5-31.57,0-.23.1-.43.1-.63v-32c0-8.84-7.16-16-16-16s-16,7.16-16,16v32h-64v-32c0-8.84-7.16-16-16-16s-16,7.16-16,16v32c0,.24.13.44.14.67-20.95,1.69-39.98,13.14-50.51,31.58l-101.2,177.1c-5.53,9.67-8.43,20.62-8.43,31.76v14.89c0,35.2,28.8,64,64,64h319.1c35.2,0,64-28.8,64-64v-14.94c0-11.14-2.91-22.08-8.44-31.76l-100.26-177.1Zm76.7,223.8c0,17.67-14.33,32-32,32H96c-17.67,0-32-14.33-32-32v-15c0-5.57,1.45-11.04,4.22-15.88l101.2-176.1c5.68-10.82,16.28-17.02,27.78-17.02h117.7c11.46,0,22.04,6.14,27.73,16.09l101.2,177c2.76,4.83,4.22,10.31,4.22,15.88v15.03h-.95Z' }), ' ']), ' ']), ' ']), ' ', el('div', { className: 'col-span-7 pt-6' }, [' ', el(RichText.Content, { tagName: 'h4', className: 'pl-1.5 font-serif text-base uppercase text-white', value: propOrDefault( props.attributes.mo_phone, 'mo_phone' ) }), ' ']), ' ', el('div', { className: 'col-span-1 grid place-items-center pt-6' }, [' ', el('svg', { id: 'Layer_2', 'data-name': 'Layer 2', xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 512 384', 'preserveAspectRatio': '', className: 'fill-primary-NORMAL text-base w-6' }, [' ', el('g', { id: 'Layer_1-2', 'data-name': 'Layer 1' }, [' ', el('path', { d: 'm0,64C0,28.65,28.65,0,64,0h384c35.3,0,64,28.65,64,64v256c0,35.3-28.7,64-64,64H64c-35.35,0-64-28.7-64-64V64Zm32,0v39.9l195.6,143.4c16.9,12.4,39.9,12.4,56.8,0l195.6-143.4v-39.9c0-17.7-14.3-32-32-32H63.1c-16.77,0-32,14.3-32,32h.9Zm0,79.6v176.4c0,17.7,14.33,32,32,32h384c17.7,0,32-14.3,32-32v-176.4l-176.7,129.5c-28.2,20.7-66.4,20.7-94.6,0L32,143.6Z' }), ' ']), ' ']), ' ']), ' ', el('div', { className: 'col-span-7 pt-6' }, [' ', el(RichText.Content, { tagName: 'h4', className: 'pl-2 font-serif text-base lowercase text-white', value: propOrDefault( props.attributes.mo_contact_email_text, 'mo_contact_email_text' ) }), ' ']), ' ']), ' ']), ' ', el('div', { className: 'col-span-3 row-span-1 w-auto md:col-span-2' }, [' ', el('div', { id: 'map-box', className: 'h-96 map-box py-56 w-auto' }, [' ', el('script', { 'async': '', src: 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDCjQbOAcZR002cGDTl_hchKl_Oo9vI33U&callback=initMap', 'data-pg-name': 'Google Maps' }), ' ', el('link', { rel: 'icon', type: 'image/svg+xml', href: 'favicon.svg' }), ' ', el('link', { rel: 'icon', type: 'image/png', href: 'favicon.png' }), ' ']), ' ']), ' ']), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
