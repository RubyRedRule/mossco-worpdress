
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
    
    const block = registerBlockType( 'mossco-fse/mo-footer-social', {
        apiVersion: 2,
        title: 'Footer Social icon block',
        description: '',
        icon: 'block-default',
        category: 'text',
        parent: [ 'mossco-fse/mo-footer-section' ],

        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            mo_social_link: {
                type: 'object',
                default: {post_id: 0, url: '#', title: '', 'post_type': null},
            },
            mo_social_icon: {
                type: 'object',
                default: {id: 0, url: '', size: '', svg: `<svg viewBox="0 0 175.37 175.37" fill="currentColor" class="h-10 w-10 lg:hover:fill-primary-LIGHT"> 
    <path d="m156.58,0H18.79C8.41,0,0,8.41,0,18.79v137.79c0,10.38,8.41,18.79,18.79,18.79h53.73v-59.62h-24.66v-28.06h24.66v-21.39c0-24.33,14.48-37.77,36.67-37.77,10.62,0,21.73,1.89,21.73,1.89v23.88h-12.24c-12.06,0-15.82,7.48-15.82,15.16v18.22h26.92l-4.31,28.06h-22.62v59.62h53.73c10.38,0,18.79-8.41,18.79-18.79V18.79c0-10.38-8.41-18.79-18.79-18.79Z"/>
</svg>`, alt: null},
            }
        },
        example: { attributes: { mo_social_link: {post_id: 0, url: '#', title: '', 'post_type': null}, mo_social_icon: {id: 0, url: '', size: '', svg: `<svg viewBox="0 0 175.37 175.37" fill="currentColor" class="h-10 w-10 lg:hover:fill-primary-LIGHT"> 
    <path d="m156.58,0H18.79C8.41,0,0,8.41,0,18.79v137.79c0,10.38,8.41,18.79,18.79,18.79h53.73v-59.62h-24.66v-28.06h24.66v-21.39c0-24.33,14.48-37.77,36.67-37.77,10.62,0,21.73,1.89,21.73,1.89v23.88h-12.24c-12.06,0-15.82,7.48-15.82,15.16v18.22h26.92l-4.31,28.06h-22.62v59.62h53.73c10.38,0,18.79-8.41,18.79-18.79V18.79c0-10.38-8.41-18.79-18.79-18.79Z"/>
</svg>`, alt: null} } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ href: propOrDefault( props.attributes.mo_social_link.url, 'mo_social_link', 'url' ), 'aria-label': 'facebook', className: 'hover:text-gray-200', onClick: function(e) { e.preventDefault(); } });
            const setAttributes = props.setAttributes; 
            
            props.mo_social_icon = useSelect(function( select ) {
                return {
                    mo_social_icon: props.attributes.mo_social_icon.id ? select('core').getMedia(props.attributes.mo_social_icon.id) : undefined
                };
            }, [props.attributes.mo_social_icon] ).mo_social_icon;
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('a', { ...blockProps }, [' ', props.attributes.mo_social_icon && !props.attributes.mo_social_icon.url && propOrDefault( props.attributes.mo_social_icon.svg, 'mo_social_icon', 'svg' ) && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_social_icon.svg, 'mo_social_icon', 'svg' ), { className: 'h-10 w-10 lg:hover:fill-primary-LIGHT' })), props.attributes.mo_social_icon && props.attributes.mo_social_icon.url && el('img', { className: 'h-10 w-10 lg:hover:fill-primary-LIGHT ' + (props.attributes.mo_social_icon.id ? ('wp-image-' + props.attributes.mo_social_icon.id) : ''), src: propOrDefault( props.attributes.mo_social_icon.url, 'mo_social_icon', 'url' ) })]),                        
                
                    el( InspectorControls, {},
                        [
                            
                        pgMediaImageControl('mo_social_icon', setAttributes, props, 'full', true, 'Social Icon', '' ),
                                        
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    pgUrlControl('mo_social_link', setAttributes, props, 'Social Link', '', null ),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ href: propOrDefault( props.attributes.mo_social_link.url, 'mo_social_link', 'url' ), 'aria-label': 'facebook', className: 'hover:text-gray-200', onClick: function(e) { e.preventDefault(); } });
            return el('a', { ...blockProps }, [' ', props.attributes.mo_social_icon && !props.attributes.mo_social_icon.url && propOrDefault( props.attributes.mo_social_icon.svg, 'mo_social_icon', 'svg' ) && pgCreateSVG(RawHTML, {}, pgMergeInlineSVGAttributes(propOrDefault( props.attributes.mo_social_icon.svg, 'mo_social_icon', 'svg' ), { className: 'h-10 w-10 lg:hover:fill-primary-LIGHT' })), props.attributes.mo_social_icon && props.attributes.mo_social_icon.url && el('img', { className: 'h-10 w-10 lg:hover:fill-primary-LIGHT ' + (props.attributes.mo_social_icon.id ? ('wp-image-' + props.attributes.mo_social_icon.id) : ''), src: propOrDefault( props.attributes.mo_social_icon.url, 'mo_social_icon', 'url' ) })]);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
