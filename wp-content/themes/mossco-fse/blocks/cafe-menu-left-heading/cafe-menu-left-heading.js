
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
    
    const block = registerBlockType( 'mossco-fse/cafe-menu-left-heading', {
        apiVersion: 2,
        title: 'Top Heading Section',
        description: '',
        icon: 'block-default',
        category: 'mo_menu_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
            cafe_menu_h3: {
                type: 'text',
                default: `Café`,
            },
            cafe_menu_h4: {
                type: 'text',
                default: `Sandwiches`,
            },
            cafe_menu_exerpt: {
                type: 'text',
                default: `Pre-made, cut and deli wrapped, available hot or cold. Served with daily soup, available from 12noon. <br>Take out or eat in.`,
            }
        },
        example: { attributes: { cafe_menu_h3: `Café`, cafe_menu_h4: `Sandwiches`, cafe_menu_exerpt: `Pre-made, cut and deli wrapped, available hot or cold. Served with daily soup, available from 12noon. <br>Take out or eat in.` } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'col-span-1 menu', 'data-pg-name': 'Menu col 1' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('div', { ...blockProps }, [' ', el(RichText, { tagName: 'h3', className: 'font-sans text-3xl text-primary-NORMAL uppercase', value: propOrDefault( props.attributes.cafe_menu_h3, 'cafe_menu_h3' ), onChange: function(val) { setAttributes( {cafe_menu_h3: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'h4', className: 'border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase', value: propOrDefault( props.attributes.cafe_menu_h4, 'cafe_menu_h4' ), onChange: function(val) { setAttributes( {cafe_menu_h4: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', el(RichText, { tagName: 'p', className: 'caption pb-8 pt-6 text-mossco_faint_teal-faintteal', value: propOrDefault( props.attributes.cafe_menu_exerpt, 'cafe_menu_exerpt' ), onChange: function(val) { setAttributes( {cafe_menu_exerpt: val }) }, withoutInteractiveFormatting: true, allowedFormats: [] }), ' ', ' ', ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Honey glazed ham'), ' ', el('dd', {}, 'Smoked Hegarty’s cheddar, house slaw, rocket, onion, mustard mayo & Ballymaloe relish.'), ' ', el('p', { className: 'allergen_info' }, '(10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Reuben'), ' ', el('dd', {}, 'Pastrami, swiss cheese, sauerkraut, pickles & Russian dressing'), ' ', el('p', { className: 'allergen_info' }, '(2,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Turkey Caesar club'), ' ', el('dd', {}, 'Sliced turkey, crispy bacon, sliced cheddar, tomato, egg & baby gem with Caesar mayo'), ' ', el('p', { className: 'allergen_info' }, '(2,5,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Roast chicken'), ' ', el('dd', {}, 'Tandoori mayo, pickled red onions, shaved carrot, coriander & baby gem on ciabatta.'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Warm, crispy bacon'), ' ', el('dd', {}, 'Brie, and red onion jam ciabatta (HOT)'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Buffalo mozzarella'), ' ', el('dd', {}, 'Roasted red peppers, artichokes, rocket & basil tomato pesto aioli on ciabatta. (HOT)'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Ploughman’s honey glazed ham'), ' ', el('dd', {}, 'Hegarty’s cheddar, pickled red onion, slice apple, Branston pickle and watercress baguette. '), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Classic croque monsieur'), ' ', el('dd', {}, '(HOT)'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Poached chicken'), ' ', el('dd', {}, 'Avocado, tomato, red onion & rocket, citrus aioli on wholegrain'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Tuna & avocado'), ' ', el('dd', {}, 'With pickled veg & coriander wrap. Warm beetroot, spinach & goats cheese ciabatta (HOT)'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ']),                        
                
                    el( InspectorControls, {},
                        [
                            
                            el(Panel, {},
                                el(PanelBody, {
                                    title: __('Block properties')
                                }, [
                                    
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_h3,
                                        help: __( '' ),
                                        label: __( 'Menu Title' ),
                                        onChange: function(val) { setAttributes({cafe_menu_h3: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_h4,
                                        help: __( '' ),
                                        label: __( 'Menu Category Sub Title' ),
                                        onChange: function(val) { setAttributes({cafe_menu_h4: val}) },
                                        type: 'text'
                                    }),
                                    el(TextControl, {
                                        value: props.attributes.cafe_menu_exerpt,
                                        help: __( '' ),
                                        label: __( 'Menu Exerpt' ),
                                        onChange: function(val) { setAttributes({cafe_menu_exerpt: val}) },
                                        type: 'text'
                                    }),    
                                ])
                            )
                        ]
                    )                            

            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ className: 'col-span-1 menu', 'data-pg-name': 'Menu col 1' });
            return el('div', { ...blockProps }, [' ', el(RichText.Content, { tagName: 'h3', className: 'font-sans text-3xl text-primary-NORMAL uppercase', value: propOrDefault( props.attributes.cafe_menu_h3, 'cafe_menu_h3' ) }), ' ', el(RichText.Content, { tagName: 'h4', className: 'border-b-2 border-primary-NORMAL border-solid font-sans py-2 text-Mossco-grey-semi text-xl uppercase', value: propOrDefault( props.attributes.cafe_menu_h4, 'cafe_menu_h4' ) }), ' ', el(RichText.Content, { tagName: 'p', className: 'caption pb-8 pt-6 text-mossco_faint_teal-faintteal', value: propOrDefault( props.attributes.cafe_menu_exerpt, 'cafe_menu_exerpt' ) }), ' ', ' ', ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Honey glazed ham'), ' ', el('dd', {}, 'Smoked Hegarty’s cheddar, house slaw, rocket, onion, mustard mayo & Ballymaloe relish.'), ' ', el('p', { className: 'allergen_info' }, '(10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Reuben'), ' ', el('dd', {}, 'Pastrami, swiss cheese, sauerkraut, pickles & Russian dressing'), ' ', el('p', { className: 'allergen_info' }, '(2,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Turkey Caesar club'), ' ', el('dd', {}, 'Sliced turkey, crispy bacon, sliced cheddar, tomato, egg & baby gem with Caesar mayo'), ' ', el('p', { className: 'allergen_info' }, '(2,5,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Roast chicken'), ' ', el('dd', {}, 'Tandoori mayo, pickled red onions, shaved carrot, coriander & baby gem on ciabatta.'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Warm, crispy bacon'), ' ', el('dd', {}, 'Brie, and red onion jam ciabatta (HOT)'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Buffalo mozzarella'), ' ', el('dd', {}, 'Roasted red peppers, artichokes, rocket & basil tomato pesto aioli on ciabatta. (HOT)'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Ploughman’s honey glazed ham'), ' ', el('dd', {}, 'Hegarty’s cheddar, pickled red onion, slice apple, Branston pickle and watercress baguette. '), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Classic croque monsieur'), ' ', el('dd', {}, '(HOT)'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Poached chicken'), ' ', el('dd', {}, 'Avocado, tomato, red onion & rocket, citrus aioli on wholegrain'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ', el('div', { className: 'menu_item' }, [' ', el('dt', {}, 'Tuna & avocado'), ' ', el('dd', {}, 'With pickled veg & coriander wrap. Warm beetroot, spinach & goats cheese ciabatta (HOT)'), ' ', el('p', { className: 'allergen_info' }, '(1,2,9,10,4)'), ' ', el('p', { className: 'price' }, '€5.50'), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
