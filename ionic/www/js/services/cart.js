angular.module('starter.services')
    .service('$cart', ['$localStorage', function ($localStorage) {
        var key = 'cart', cartAux = $localStorage.getObject(key);
        initCart();

        //console.log($localStorage.getObject(key));


        if (!cartAux) {
            initCart();
        }

        this.clear = function () {
            initCart();
        };

        this.get = function () {
            return $localStorage.getObject(key);
        };

        this.getItem = function (id) {
            return this.get().items[id];
        };

        this.addItem = function (item) {
            //console.log(item);
            var cart = this.get(), itemAux, exists = false;
            console.log(cart);
            for (var index in cart.items) {
                itemAux = cart.items[index];
                if (itemAux.id == item.qtd) {
                    itemAux.qtd = item.qtd + itemAux.qtd;
                    itemAux.subtotal = calcularSubTotal(itemAux);
                    exists = true;
                    break;
                }
            }
            if (!exists) {
                item.subtotal = calcularSubTotal(item);
                cart.items.push(item);
            }
            cart.total = getTotal(cart.items);
            $localStorage.setObject(key, cart);
        };

        this.removeItem = function (id) {
            var cart = this.get();
            cart.items.splice(id, 1);
            cart.total = getTotal(cart.items);
            $localStorage.setObject(key, cart);
        };

        this.updateQtd = function(i, qtd){
            var cart = this.get(), itemAux = cart.items[i];
            console.log(itemAux);
            itemAux.qtd = qtd;
            itemAux.subtotal = calcularSubTotal(itemAux);
            cart.total = getTotal(cart.items);
            $localStorage.setObject(key, cart);
        };

        // private methods
        function calcularSubTotal(item) {
            return item.price * item.qtd;
        };

        function getTotal(items) {
            var sum = 0;
            angular.forEach(items, function (item) {
                sum += item.subtotal;
            });
            return sum;
        };


        this.setCupom = function (code, value) {
            var cart = this.get();
            cart.cupom = {
                code: code,
                value: value
            }
            $localStorage.setObject(key, cart);
        };

        this.removeCupom = function () {
            var cart = this.get();
            cart.cupom = {
                code: null,
                value: null
            }
            $localStorage.setObject(key, cart);
        };

        this.getTotalFinal = function() {
            var cart = this.get();
            return cart.total - (cart.cupom.value || 0);
        }

        function initCart() {
            $localStorage.setObject(key, {
                cupom: {code: null, value: null},
                items: [],
                total: 0
            });
        };

    }]);