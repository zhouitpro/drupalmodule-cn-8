/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

eval("jQuery(function ($) {\n\n});\n\n(function ($, Drupal) {\n    $(function() {\n        if ($(\".load_downloads\").length > 0) {\n            var ProjectVars = drupalSettings.dm_project;\n            if (ProjectVars.is_core_module) {\n                $(\".load_downloads\").parents(\"#block-module-download\").remove();\n            } else {\n                $.get(\"/api/get_download/\" + ProjectVars.project_id, function (data) {\n                    $(\".load_downloads\").html(data);\n                });\n            }\n        }\n\n        var fixed = false;\n        var div = $(\"#block-rightmenu\");\n        if(div.length > 0) {\n            var tops = div.offset().top;\n            if (div.length > 0) {\n                $(window).scroll(function() {\n                    if ($(this).scrollTop() > tops) {\n                        if( !fixed ) {\n                            fixed = true;\n                            div.addClass('directoryfixed');\n                        }\n                    } else {\n                        if( fixed ) {\n                            fixed = false;\n                            div.removeClass('directoryfixed');\n                        }\n                    }\n                });\n            }}\n    });\n\n\n})(jQuery, Drupal);//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9zcmMvanMvYXBwLmpzPzcxNmYiXSwic291cmNlc0NvbnRlbnQiOlsialF1ZXJ5KGZ1bmN0aW9uICgkKSB7XG5cbn0pO1xuXG4oZnVuY3Rpb24gKCQsIERydXBhbCkge1xuICAgICQoZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICgkKFwiLmxvYWRfZG93bmxvYWRzXCIpLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIHZhciBQcm9qZWN0VmFycyA9IGRydXBhbFNldHRpbmdzLmRtX3Byb2plY3Q7XG4gICAgICAgICAgICBpZiAoUHJvamVjdFZhcnMuaXNfY29yZV9tb2R1bGUpIHtcbiAgICAgICAgICAgICAgICAkKFwiLmxvYWRfZG93bmxvYWRzXCIpLnBhcmVudHMoXCIjYmxvY2stbW9kdWxlLWRvd25sb2FkXCIpLnJlbW92ZSgpO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAkLmdldChcIi9hcGkvZ2V0X2Rvd25sb2FkL1wiICsgUHJvamVjdFZhcnMucHJvamVjdF9pZCwgZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgICAgICAgICAgICAgJChcIi5sb2FkX2Rvd25sb2Fkc1wiKS5odG1sKGRhdGEpO1xuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgdmFyIGZpeGVkID0gZmFsc2U7XG4gICAgICAgIHZhciBkaXYgPSAkKFwiI2Jsb2NrLXJpZ2h0bWVudVwiKTtcbiAgICAgICAgaWYoZGl2Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIHZhciB0b3BzID0gZGl2Lm9mZnNldCgpLnRvcDtcbiAgICAgICAgICAgIGlmIChkaXYubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgICAgICQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmICgkKHRoaXMpLnNjcm9sbFRvcCgpID4gdG9wcykge1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYoICFmaXhlZCApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaXhlZCA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGl2LmFkZENsYXNzKCdkaXJlY3RvcnlmaXhlZCcpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYoIGZpeGVkICkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZpeGVkID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZGl2LnJlbW92ZUNsYXNzKCdkaXJlY3RvcnlmaXhlZCcpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB9fVxuICAgIH0pO1xuXG5cbn0pKGpRdWVyeSwgRHJ1cGFsKTtcblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gc3JjL2pzL2FwcC5qcyJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VSb290IjoiIn0=");

/***/ }
/******/ ]);