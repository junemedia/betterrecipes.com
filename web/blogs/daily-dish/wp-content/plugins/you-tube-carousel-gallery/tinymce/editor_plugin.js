(function() {
	tinymce.create('tinymce.plugins.YTC', {
		init : function(ed, url) {
			//register a Command
			ed.addCommand('YTC', function() {
				ed.windowManager.open({
					file : url + '/dialog.htm',
					width : 420 + ed.getLang('YTC.delta_width', 0),
					height : 600 + ed.getLang('YTC.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
			});
			//register aButton
			ed.addButton('YTC', {
				title : 'YTC: Youtube Carousel Gallery',
				image : url+'/youtube.png',
				cmd   : 'YTC',
				/*onclick : function() {
					idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
					var vidId = prompt("YouTube Video", "Enter the id or url for your video");
					var m = idPattern.exec(vidId);
					if (m != null && m != 'undefined')
						ed.execCommand('mceInsertContent', false, '[youtube id="'+m[1]+'"]');
				}*/
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "YouTube Carousel Gallery",
				author : 'Ramandeep Singh',
				authorurl : 'http://www.ramandeepsingh.in/',
				infourl : 'http://www.designaeon.com/',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('YTC', tinymce.plugins.YTC);
})();