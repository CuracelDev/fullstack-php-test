(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[7],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/cart.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/cart.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _utils_toast__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/toast */ "./resources/js/utils/toast.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Cart",
  data: function data() {
    return {
      cartHeader: [{
        text: '#',
        value: 'number',
        sortable: false,
        orderable: false
      }, {
        text: 'Name',
        value: 'name'
      }, {
        text: 'Amount',
        value: 'amount'
      }, {
        text: 'Discount',
        value: 'discount'
      }, {
        text: 'Image',
        value: 'img_url'
      }],
      form: {
        coupons: '',
        coupon_discount: 0,
        discount_amount: 0,
        used_coupon: [],
        prev_total: 0,
        products: []
      },
      toast: new _utils_toast__WEBPACK_IMPORTED_MODULE_2__["default"](),
      cart_amount: [],
      btnLoading: false,
      loading: false
    };
  },
  created: function created() {
    var _this = this;

    this.cartAmount();
    this.form.products = this.cart;
    this.$root.$on('clear-discount', function () {
      _this.clearDiscount();
    });
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('orders', ['place_order'])), {}, {
    applyCoupon: function applyCoupon() {
      var _this2 = this;

      this.btnLoading = true;
      setTimeout(function () {
        _this2.btnLoading = false;
      }, 1000);
      var coupon = this.coupons.find(function (x) {
        return x.code === _this2.form.coupons;
      });

      if (typeof coupon === 'undefined') {
        this.toast.showMessage('Coupon not found or has expired', 'error');
      } else if (!this.checkUserCoupon(coupon)) {
        this.toast.showMessage('Coupon not valid for your account', 'error');
      } else if (!this.checkProductCoupon(coupon)) {
        this.toast.showMessage('Coupon not found for any product in your cart', 'error');
      } else {
        if (this.form.used_coupon.find(function (x) {
          return x === coupon.code;
        })) {
          this.toast.showMessage('Coupon already applied', 'error');
        } else {
          if (!this.form.used_coupon.find(function (x) {
            return x === coupon.code;
          })) {
            this.form.used_coupon.push(coupon.code);
          }

          return this.total;
        }
      }
    },
    placeOrder: function placeOrder() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this3.loading = true;
                _context.prev = 1;
                _context.next = 4;
                return _this3.place_order(_this3.form);

              case 4:
                response = _context.sent;

                _this3.toast.successMessage(response);

                _this3.loading = false;
                _context.next = 13;
                break;

              case 9:
                _context.prev = 9;
                _context.t0 = _context["catch"](1);

                _this3.toast.errorMessage(_context.t0);

                _this3.loading = false;

              case 13:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[1, 9]]);
      }))();
    },
    checkUserCoupon: function checkUserCoupon(coupon) {
      return coupon.user_id === this.user.id;
    },
    checkProductCoupon: function checkProductCoupon(coupon) {
      var _this4 = this;

      this.btnLoading = true;
      var carts = this.cart;
      var products = carts.filter(function (item1) {
        return coupon.products.find(function (item2) {
          return item1.id === item2.id;
        });
      });

      if (products) {
        var _loop = function _loop(i) {
          var coupon_percentage = coupon.discount_percentage;
          _this4.form.coupon_discount += coupon_percentage / 100 * products[i].amount;
          var item = carts.find(function (x) {
            return x.id === carts[i].id;
          });

          if (item) {
            item['discount'] = coupon_percentage / 100 * products[i].amount;
          }

          _this4.cartAmount(products[i], _this4.form.coupon_discount);
        };

        for (var i = 0; i < products.length; i++) {
          _loop(i);
        }

        this.form.discount_amount = this.form.coupon_discount;
        setTimeout(function () {
          _this4.form.coupon_discount = 0;
        }, 1000);
        return true;
      }

      return false;
    },
    cartAmount: function cartAmount(product, discount) {
      var amount = 0;
      var cart = this.cart;

      for (var i = 0; i < cart.length; i++) {
        amount += product && cart[i].amount === product.amount ? discount : cart[i].amount;
      }

      return amount;
    },
    clearDiscount: function clearDiscount() {
      this.form = {};
      var cart = this.cart;

      for (var i = 0; i < cart.length; i++) {
        if (cart[i].discount) {
          delete cart[i].discount;
        }
      }
    }
  }),
  computed: _objectSpread(_objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('cart', ['cart'])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('auth', ['user'])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('coupons', ['coupons'])), {}, {
    subTotal: function subTotal() {
      return this.cartAmount();
    },
    total: function total() {
      var subTotal = this.cartAmount();
      var tax = this.user.tax_percentage / 100;
      var taxed_amount = subTotal * tax;
      var total = subTotal + taxed_amount - this.form.discount_amount;
      this.form.amount = total;
      return total;
    }
  })
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/cart.vue?vue&type=template&id=30c532c2&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/cart.vue?vue&type=template&id=30c532c2&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "v-row",
        { staticClass: "pa-4" },
        [
          _c(
            "v-col",
            { attrs: { cols: "12", md: "8" } },
            [
              _c(
                "v-card",
                { attrs: { elevation: "2" } },
                [
                  _c(
                    "v-toolbar",
                    { attrs: { flat: "" } },
                    [
                      _c("v-card-title", { staticClass: "px-0" }, [
                        _vm._v("Cart Items")
                      ])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("v-data-table", {
                    attrs: {
                      headers: _vm.cartHeader,
                      items: _vm.cart,
                      "hide-default-footer": true,
                      "item-key": "id"
                    },
                    scopedSlots: _vm._u(
                      [
                        {
                          key: "item.number",
                          fn: function(ref) {
                            var index = ref.index
                            return [_c("div", [_vm._v(_vm._s(index + 1))])]
                          }
                        },
                        {
                          key: "item.discount",
                          fn: function(ref) {
                            var item = ref.item
                            return [
                              _c("div", [
                                _vm._v(
                                  _vm._s(item.discount ? item.discount : "0")
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "item.img_url",
                          fn: function(ref) {
                            var item = ref.item
                            return [
                              _c("v-img", {
                                attrs: {
                                  src: item.img_url,
                                  width: "30",
                                  height: "30"
                                }
                              })
                            ]
                          }
                        }
                      ],
                      null,
                      true
                    )
                  })
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-col",
            [
              _c(
                "v-card",
                { attrs: { elevation: "2" } },
                [
                  _c(
                    "v-toolbar",
                    { attrs: { flat: "" } },
                    [
                      _c("v-card-title", { staticClass: "px-0" }, [
                        _vm._v("Cart Summary")
                      ]),
                      _vm._v(" "),
                      _c(
                        "v-row",
                        { attrs: { justify: "end" } },
                        [
                          _c(
                            "v-btn",
                            {
                              staticClass: "mr-lg-3",
                              attrs: {
                                small: "",
                                outlined: "",
                                color: "error"
                              },
                              on: {
                                click: function($event) {
                                  return _vm.clearCart()
                                }
                              }
                            },
                            [_vm._v("Clear Cart")]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-form",
                    { ref: "form", staticClass: "px-4" },
                    [
                      _c("v-text-field", {
                        staticClass: "mb-n2",
                        attrs: {
                          outlined: "",
                          dense: "",
                          placeholder: "Enter coupon if any"
                        },
                        model: {
                          value: _vm.form.coupons,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "coupons", $$v)
                          },
                          expression: "form.coupons"
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "v-btn",
                        {
                          attrs: { color: "primary", loading: _vm.btnLoading },
                          on: { click: _vm.applyCoupon }
                        },
                        [_vm._v("Apply")]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("v-card-title", { staticClass: "pb-0" }, [
                    _vm._v("SubTotal: ₦" + _vm._s(_vm.subTotal))
                  ]),
                  _vm._v(" "),
                  _c("v-card-title", { staticClass: "py-0" }, [
                    _vm._v("Tax: " + _vm._s(_vm.user.tax_percentage) + "%")
                  ]),
                  _vm._v(" "),
                  _c("v-card-title", { staticClass: "py-0" }, [
                    _vm._v("Total: ₦" + _vm._s(_vm.total))
                  ]),
                  _vm._v(" "),
                  _c(
                    "v-card-actions",
                    [
                      _c(
                        "v-btn",
                        {
                          attrs: {
                            block: "",
                            outlined: "",
                            color: "primary",
                            loading: _vm.loading
                          },
                          on: {
                            click: function($event) {
                              return _vm.placeOrder()
                            }
                          }
                        },
                        [_vm._v("Place Order")]
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/utils/toast.js":
/*!*************************************!*\
  !*** ./resources/js/utils/toast.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Toasts; });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_toastification__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-toastification */ "./node_modules/vue-toastification/dist/esm/index.js");
/* harmony import */ var vue_toastification_dist_index_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-toastification/dist/index.css */ "./node_modules/vue-toastification/dist/index.css");
/* harmony import */ var vue_toastification_dist_index_css__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_toastification_dist_index_css__WEBPACK_IMPORTED_MODULE_2__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }




vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_toastification__WEBPACK_IMPORTED_MODULE_1__["default"]);
var toast = vue__WEBPACK_IMPORTED_MODULE_0___default.a.$toast;

var Toasts = /*#__PURE__*/function () {
  function Toasts() {
    _classCallCheck(this, Toasts);
  }

  _createClass(Toasts, [{
    key: "showMessage",
    value: function showMessage(message, type) {
      if (type === 'success') {
        toast.success(message);
      } else {
        toast.error(message);
      }
    }
  }, {
    key: "successMessage",
    value: function successMessage(response) {
      this.showMessage(response.data.message, 'success');
    }
  }, {
    key: "errorMessage",
    value: function errorMessage(error) {
      if (error.response.status === 500) {
        this.showMessage('Something went wrong, please try again', 'error');
      } else if (error.response.status === 422) {
        this.showMessage(error.response.message[0], 'error');
      } else {
        this.showMessage(error.response.data.message, 'error');
      }
    }
  }]);

  return Toasts;
}();



/***/ }),

/***/ "./resources/js/views/cart.vue":
/*!*************************************!*\
  !*** ./resources/js/views/cart.vue ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _cart_vue_vue_type_template_id_30c532c2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./cart.vue?vue&type=template&id=30c532c2&scoped=true& */ "./resources/js/views/cart.vue?vue&type=template&id=30c532c2&scoped=true&");
/* harmony import */ var _cart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./cart.vue?vue&type=script&lang=js& */ "./resources/js/views/cart.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _cart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _cart_vue_vue_type_template_id_30c532c2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _cart_vue_vue_type_template_id_30c532c2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "30c532c2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/cart.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/cart.vue?vue&type=script&lang=js&":
/*!**************************************************************!*\
  !*** ./resources/js/views/cart.vue?vue&type=script&lang=js& ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_cart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./cart.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/cart.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_cart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/cart.vue?vue&type=template&id=30c532c2&scoped=true&":
/*!********************************************************************************!*\
  !*** ./resources/js/views/cart.vue?vue&type=template&id=30c532c2&scoped=true& ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_cart_vue_vue_type_template_id_30c532c2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./cart.vue?vue&type=template&id=30c532c2&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/cart.vue?vue&type=template&id=30c532c2&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_cart_vue_vue_type_template_id_30c532c2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_cart_vue_vue_type_template_id_30c532c2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);