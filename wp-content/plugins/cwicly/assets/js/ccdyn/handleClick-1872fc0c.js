import{I as t,m as e,_ as a}from"./main-f3bc643b.js";function i(i,r,n){let o;const u=(t,e=0)=>{clearTimeout(o),o=setTimeout((()=>{t()}),e)};if(i.item.isWooCart&&i.repeaterData&&i.attributes?.link?.url?.type&&"dynamic"===i.attributes.link.url.type&&("woostepup"===i.attributes.link.url.href||"woostepdown"===i.attributes.link.url.href)){i.e.preventDefault();let t=0;"woostepup"===i.attributes.link.url.href?i.repeaterData?.quantity_limits?.maximum?i.repeaterData.quantity+1<=i.repeaterData.quantity_limits.maximum&&(t=parseInt(i.repeaterData.quantity+1)):t=parseInt(i.repeaterData.quantity+1):i.repeaterData?.quantity_limits?.minimum?i.repeaterData.quantity-1>=i.repeaterData.quantity_limits.minimum&&(t=parseInt(i.repeaterData.quantity-1)):t=parseInt(i.repeaterData.quantity-1),t&&u((()=>{const r=new CustomEvent("cc-woo-cart",{detail:{state:"loading"}});document.dispatchEvent(r),e(`wc/store/v1/cart/update-item?key=${i.repeaterData.key}&quantity=${t}`,{},"POST",!1).then((t=>{a.update((e=>t));const e=new CustomEvent("cc-woo-cart",{detail:{state:"loaded",cart:t}});document.dispatchEvent(e)}))}),80)}else if(i.item.isWooCart&&i.repeaterData&&i.attributes?.link?.url?.type&&"dynamic"===i.attributes.link.url.type&&"woocartitemremove"===i.attributes.link.url.href)u((()=>{const t=new CustomEvent("cc-woo-cart",{detail:{state:"loading"}});document.dispatchEvent(t),e(`wc/store/v1/cart/remove-item?key=${i.repeaterData.key}`,{},"POST",!1).then((t=>{a.update((e=>t));const e=new CustomEvent("cc-woo-cart",{detail:{state:"loaded",cart:t}});document.dispatchEvent(e)}))}),0);else if(i.attributes?.link?.url?.type&&"dynamic"===i.attributes.link.url.type&&"wooaddtocart"===i.attributes.link.url.href&&("simple"===i.item.type&&!i.attributes.link.url?.extra?.redirectSimple||"variable"===i.item.type&&!i.attributes.link.url?.extra?.redirectVariable)&&"grouped"!=i.item.type&&"external"!=i.item.type)if("variable"===i.item.type){const t=i.wooProducts[`${i.dataQueryID}-${i.item.id}-cart`]?i.wooProducts[`${i.dataQueryID}-${i.item.id}-cart`].attributes:null;t&&(r=[...r,"loading"],n(r),CCers&&CCers.woo&&CCers.woo.nonce&&fetch(`${CCers.restBase}/wc/store/v1/cart/add-item?id=${i.item.id}&quantity=${i.item.min_purchase_quantity}`,{method:"POST",headers:{"X-WP-Nonce":CCers.nonce,Nonce:CCers.woo.nonce,"Content-Type":"application/json"},body:JSON.stringify({variation:t})}).then((t=>t.json())).then((t=>{if(t){r=r.filter((function(t){return"loading"!==t})),r=[...r,"added"],n(r);const e=new CustomEvent("cc-woo-cart-mod",{detail:{cart:t}});document.dispatchEvent(e),setTimeout((()=>{r=r.filter((function(t){return"added"!==t})),n(r)}),1500)}})).catch((t=>console.error(t))))}else i.item.is_purchasable&&i.item.is_in_stock&&(r=[...r,"loading"],n(r),CCers&&CCers.woo&&CCers.woo.nonce&&fetch(`${CCers.restBase}/wc/store/v1/cart/add-item?id=${i.item.id}&quantity=${i.item.min_purchase_quantity}`,{method:"POST",headers:{"X-WP-Nonce":CCers.nonce,Nonce:CCers.woo.nonce}}).then((t=>t.json())).then((t=>{if(t){r=r.filter((function(t){return"loading"!==t})),r=[...r,"added"],n(r);const e=new CustomEvent("cc-woo-cart-mod",{detail:{cart:t}});document.dispatchEvent(e),setTimeout((()=>{r=r.filter((function(t){return"added"!==t})),n(r)}),1500)}})).catch((t=>console.error(t))));else!i.attributes?.link?.url?.type||"dynamic"!==i.attributes.link.url.type||"woostepup"!==i.attributes.link.url.href&&"woostepdown"!==i.attributes.link.url.href||t.update((t=>{const e=JSON.parse(JSON.stringify(t));if("woostepup"===i.attributes.link.url.href){const t=e[`${i.dataQueryID}-${i.item.id}-qty`]&&e[`${i.dataQueryID}-${i.item.id}-qty`]+1<=(-1!==i.item.max_purchase_quantity?i.item.max_purchase_quantity:999)?e[`${i.dataQueryID}-${i.item.id}-qty`]+1:e[`${i.dataQueryID}-${i.item.id}-qty`]?i.item.max_purchase_quantity:2;e[`${i.dataQueryID}-${i.item.id}-qty`]=t||i.item.min_purchase_quantity}else{const t=e[`${i.dataQueryID}-${i.item.id}-qty`]&&e[`${i.dataQueryID}-${i.item.id}-qty`]-1>=i.item.min_purchase_quantity?e[`${i.dataQueryID}-${i.item.id}-qty`]-1:i.item.min_purchase_quantity;e[`${i.dataQueryID}-${i.item.id}-qty`]=t||i.item.min_purchase_quantity}return e}))}export{i as wooHandleClick};