
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
    
    const block = registerBlockType( 'mossco-hc/mo-dumbblock', {
        apiVersion: 2,
        title: 'Mossco Dumb Block',
        description: '',
        icon: el('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: '24', height: '24' }, [el('path', { fill: 'none', d: 'M0 0h24v24H0z' }), el('path', { d: 'M14 10v4h-4v-4h4zm2 0h5v4h-5v-4zm-2 11h-4v-5h4v5zm2 0v-5h5v4a1 1 0 0 1-1 1h-4zM14 3v5h-4V3h4zm2 0h4a1 1 0 0 1 1 1v4h-5V3zm-8 7v4H3v-4h5zm0 11H4a1 1 0 0 1-1-1v-4h5v5zM8 3v5H3V4a1 1 0 0 1 1-1h4z' })]),
        category: 'mo_blocks',
        keywords: [],
        supports: {color: {background: false,text: false,gradients: false,link: false,},typography: {fontSize: false,},anchor: false,align: false,},
        attributes: {
        },
        example: { attributes: {  } },
        edit: function ( props ) {
            const blockProps = useBlockProps({ className: 'container max-w-screen-xl menus-bg mx-auto py-20 scroll-smooth md:py-16', id: 'home-menus', 'data-pg-ia-scene': '{"l":[{"name":"MENUS Header","t":"h3","a":"fadeInUp","p":"time","s":"30%","rev":"true"}]}', 'data-pgc': 'mossco-menus', 'data-pgc-no-update': null, 'data-pg-name': 'Dumb Block' });
            const setAttributes = props.setAttributes; 
            
            
            const innerBlocksProps = null;
            
            
            return el(Fragment, {}, [
                el('section', { ...blockProps }, [' ', el('div', {}, [' ', el('h3', { className: 'pb-4 text-3xl text-center text-primary-NORMAL uppercase md:pb-4', 'data-pg-ia-hide': '' }, 'Menus'), ' ']), ' ', el('div', { className: 'items-center justify-evenly md:flex lg:w-full xl:h-72' }, [' ', el('a', { href: 'cafe-menu.html' }, el('div', { className: 'flex h-56 items-center justify-center m-5 menu-box overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96' }, [' ', el('div', { className: 'absolute bg-center bg-cover bg-no-repeat cafe-menu-img duration-500 ease-in-out h-full hover:scale-150 rounded-sm transform transition-all w-full' }), ' ', el('h2', { className: 'absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all' }, 'Café Menu'), ' '])), ' ', el('a', { href: 'day-menu.html' }, el('div', { className: 'flex h-56 items-center justify-center m-5 menu-box menu-zoom overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96' }, [' ', el('div', { className: 'absolute bg-center bg-cover bg-no-repeat day-menu-img duration-500 ease-in-out h-full hover:scale-150 rounded-sm transform transition-all w-full' }), ' ', el('h2', { className: 'absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all' }, 'Day Menu'), ' '])), ' ', el('a', { href: 'evening-menu.html' }, el('div', { className: 'flex h-56 items-center justify-center m-5 menu-box menu-zoom overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96' }, [' ', el('div', { className: 'absolute bg-center bg-cover bg-no-repeat duration-500 ease-in-out evening-menu-img h-full hover:scale-150 rounded-sm transform transition-all w-full' }), ' ', el('h2', { className: 'absolute duration-500 ease-in-out font-bold menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all' }, 'Evening Menu'), ' '])), ' ']), ' ']),                        
                
            ]);
        },

        save: function(props) {
            const blockProps = useBlockProps.save({ className: 'container max-w-screen-xl menus-bg mx-auto py-20 scroll-smooth md:py-16', id: 'home-menus', 'data-pg-ia-scene': '{"l":[{"name":"MENUS Header","t":"h3","a":"fadeInUp","p":"time","s":"30%","rev":"true"}]}', 'data-pgc': 'mossco-menus', 'data-pgc-no-update': null, 'data-pg-name': 'Dumb Block' });
            return el('section', { ...blockProps }, [' ', el('div', {}, [' ', el('h3', { className: 'pb-4 text-3xl text-center text-primary-NORMAL uppercase md:pb-4', 'data-pg-ia-hide': '' }, 'Menus'), ' ']), ' ', el('div', { className: 'items-center justify-evenly md:flex lg:w-full xl:h-72' }, [' ', el('a', { href: 'cafe-menu.html' }, el('div', { className: 'flex h-56 items-center justify-center m-5 menu-box overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96' }, [' ', el('div', { className: 'absolute bg-center bg-cover bg-no-repeat cafe-menu-img duration-500 ease-in-out h-full hover:scale-150 rounded-sm transform transition-all w-full' }), ' ', el('h2', { className: 'absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all' }, 'Café Menu'), ' '])), ' ', el('a', { href: 'day-menu.html' }, el('div', { className: 'flex h-56 items-center justify-center m-5 menu-box menu-zoom overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96' }, [' ', el('div', { className: 'absolute bg-center bg-cover bg-no-repeat day-menu-img duration-500 ease-in-out h-full hover:scale-150 rounded-sm transform transition-all w-full' }), ' ', el('h2', { className: 'absolute duration-500 ease-in-out font-bold font-serif menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all' }, 'Day Menu'), ' '])), ' ', el('a', { href: 'evening-menu.html' }, el('div', { className: 'flex h-56 items-center justify-center m-5 menu-box menu-zoom overflow-hidden relative rounded-sm shadow-xl w-auto md:h-40 md:m-3 md:w-56 lg:h-48 lg:w-72 xl:h-52 xl:w-96' }, [' ', el('div', { className: 'absolute bg-center bg-cover bg-no-repeat duration-500 ease-in-out evening-menu-img h-full hover:scale-150 rounded-sm transform transition-all w-full' }), ' ', el('h2', { className: 'absolute duration-500 ease-in-out font-bold menu-zoom-text opacity-60 scale-150 text-lg text-white transform transition-all' }, 'Evening Menu'), ' '])), ' ']), ' ']);
        }                        

    } );
} )(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
);                        
