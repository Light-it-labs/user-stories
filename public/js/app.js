/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
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
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/nicolasfernandez/Desktop/LightIt/userStories/resources/js/app.js: Unexpected token (50:0)\n\n\u001b[0m \u001b[90m 48 | \u001b[39m    }\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 49 | \u001b[39m\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 50 | \u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<<\u001b[39m\u001b[33m<\u001b[39m \u001b[33mHEAD\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    | \u001b[39m\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 51 | \u001b[39m    components\u001b[33m:\u001b[39m{\u001b[33mUserAuthForm\u001b[39m\u001b[33m,\u001b[39m \u001b[33mForgotPassword\u001b[39m\u001b[33m,\u001b[39m \u001b[33mProjectForm\u001b[39m\u001b[33m,\u001b[39m \u001b[33mProjectIndex\u001b[39m\u001b[33m,\u001b[39m \u001b[33mDeleteModal\u001b[39m\u001b[33m,\u001b[39m \u001b[33mInviteUserForm\u001b[39m}\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 52 | \u001b[39m\u001b[33m===\u001b[39m\u001b[33m===\u001b[39m\u001b[33m=\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 53 | \u001b[39m    components\u001b[33m:\u001b[39m{\u001b[33mUserAuthForm\u001b[39m\u001b[33m,\u001b[39m \u001b[33mForgotPassword\u001b[39m\u001b[33m,\u001b[39m \u001b[33mProjectForm\u001b[39m\u001b[33m,\u001b[39m \u001b[33mProjectIndex\u001b[39m\u001b[33m,\u001b[39m \u001b[33mProject\u001b[39m}\u001b[33m,\u001b[39m\u001b[0m\n    at Parser._raise (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:748:17)\n    at Parser.raiseWithData (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:741:17)\n    at Parser.raise (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:735:17)\n    at Parser.unexpected (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9101:16)\n    at Parser.parseIdentifierName (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:11344:18)\n    at Parser.parseIdentifier (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:11317:23)\n    at Parser.parseMaybePrivateName (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10645:19)\n    at Parser.parsePropertyName (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:11130:155)\n    at Parser.parsePropertyDefinition (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:11016:22)\n    at Parser.parseObjectLike (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10931:25)\n    at Parser.parseExprAtom (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10491:23)\n    at Parser.parseExprSubscripts (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10150:23)\n    at Parser.parseUpdate (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10130:21)\n    at Parser.parseMaybeUnary (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10119:17)\n    at Parser.parseExprOps (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9989:23)\n    at Parser.parseMaybeConditional (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9963:23)\n    at Parser.parseMaybeAssign (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9926:21)\n    at /Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9893:39\n    at Parser.allowInAnd (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:11547:12)\n    at Parser.parseMaybeAssignAllowIn (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9893:17)\n    at Parser.parseExprListItem (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:11309:18)\n    at Parser.parseExprList (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:11279:22)\n    at Parser.parseNewArguments (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10858:25)\n    at Parser.parseNew (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10852:10)\n    at Parser.parseNewOrNewTarget (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10838:17)\n    at Parser.parseExprAtom (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10506:21)\n    at Parser.parseExprSubscripts (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10150:23)\n    at Parser.parseUpdate (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10130:21)\n    at Parser.parseMaybeUnary (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:10119:17)\n    at Parser.parseExprOps (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9989:23)\n    at Parser.parseMaybeConditional (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9963:23)\n    at Parser.parseMaybeAssign (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9926:21)\n    at /Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9893:39\n    at Parser.allowInAnd (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:11541:16)\n    at Parser.parseMaybeAssignAllowIn (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:9893:17)\n    at Parser.parseVar (/Users/nicolasfernandez/Desktop/LightIt/userStories/node_modules/@babel/parser/lib/index.js:12339:70)");

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/nicolasfernandez/Desktop/LightIt/userStories/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /Users/nicolasfernandez/Desktop/LightIt/userStories/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });