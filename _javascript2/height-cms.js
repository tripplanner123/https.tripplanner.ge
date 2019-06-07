// JavaScript Document
<!--
		function getWindowHeight() {
			var windowHeight = 0;
			if (typeof(window.innerHeight) == 'number') {
				windowHeight = window.innerHeight;
			}
			else {
				if (document.documentElement && document.documentElement.clientHeight) {
					windowHeight = document.documentElement.clientHeight;
				}
				else {
					if (document.body && document.body.clientHeight) {
						windowHeight = document.body.clientHeight;
					}
				}
			}
			return windowHeight;
		}
		function setFooter() {
			if (document.getElementById) {
				var windowHeight = getWindowHeight();
				if (windowHeight > 0) {
					var digitalHeight = document.getElementById('digital').offsetHeight;
					var footerElement = document.getElementById('footer');
					var footerHeight  = footerElement.offsetHeight;
					if (windowHeight - (digitalHeight + footerHeight) >= 0) {
						footerElement.style.position = 'relative';
						footerElement.style.top = (windowHeight - (digitalHeight + footerHeight)) + 'px';
					}
					else {
						footerElement.style.position = 'static';
					}
					$("#finder").height(getWindowHeight() - 240);
					$('.el-finder-nav').height(getWindowHeight() - 306);
					$('.el-finder-cwd').height(getWindowHeight() - 306);
				}
			}
		}
		window.onload = function() {
			setFooter();
		}
		window.onresize = function() {
			setFooter();
		}
		//-->