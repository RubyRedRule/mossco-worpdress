importScripts("https://cdnjs.cloudflare.com/ajax/libs/sass.js/0.11.1/sass.min.js"),self.onmessage=s=>{!async function(s){Sass.setWorkerUrl(s.data.sassURL);var a=new Sass;s.data.css?a.compile(s.data.css,(function(s){postMessage(s)})):postMessage(null)}(s)};