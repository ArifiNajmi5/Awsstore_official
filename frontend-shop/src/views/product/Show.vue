<template>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 rounded shadow">
                    <div class="card-body p-2">
                        <img :src="product.image" class="w-100 border">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <label class="font-weight-bold" style="font-size: 20px;"> {{ product.title }} </label>
                        <hr>
                        <div class="price-product" id="price-product" style="font-size: 1.35rem"><span
                                class="font-weight-bold mr-4" style="color: green">Rp. {{
                                    moneyFormat(calculateDiscount(product)) }}</span>
                            <s class="font-weight-bold" style="text-decoration-color:red">Rp. {{ moneyFormat(product.price)
                            }}</s>
                        </div>
                        <table class="table table-borderless mt-3">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">DISKON</td>
                                    <td>:</td>
                                    <td>
                                        <button class="btn btn-sm" style="color: #ff2f00;border-color: #ff2f00;">
                                            DISKON {{ product.discount }} %
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">BERAT</td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge badge-pill badge-success"
                                              style="font-size: 14px;border-radius: .3rem;padding: .25em .5em .2em;"> {{ product.weight }}
                                            gram</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">UKURAN</td>
                                    <td>:</td>
                                    <td>
                        
                                        <div v-if="product.variations?.length" v-for="variation in product.variations" :key="variation" class="form-check">
                                            <input :value="variation" class="form-check-input" type="radio" name="variation"
                                                :id="variation" @change="() => changeVariation(variation)" >
                                            <label class="form-check-label" :for="variation">
                                                {{ variation }}
                                            </label>
                                        </div>

                                        <div v-if="!product.variations?.length">
                                            -
                                        </div>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                          <button @click.prevent="addToCart(product.id, calculateDiscount(product), product.weight)" class="btn btn-primary btn-lg btn-block"><i class="fa fa-shopping-cart"></i> TAMBAH KE KERANJANG</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <label class="font-weight-bold" style="font-size: 20px;">KETERANGAN</label>
                        <hr>
                        <div v-html="product.content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import { computed, onMounted, ref } from 'vue'   // computed dan onMounted
import { useStore } from 'vuex' // store Vuex
import { useRoute, useRouter } from 'vue-router' // vue router

export default {

    name: 'ProductShowComponent',

    setup() {

        //vue route
        const route = useRoute()

        //vue router
        const router = useRouter()

        //store vuex
        const store = useStore()

        // initialVariations
        
        //onMounted akan menjalankan action "getDetailProduct" di module "product" Vuex
        onMounted(() => {
            store.dispatch('product/getDetailProduct', route.params.slug)
        })
        
        //computed properti digunakan untuk mendapatkan data detail product dari state "product" di module "product" Vuex
        const product = computed(() => {
            return store.state.product.product
        })

        let selectedVariation = ref('')
        
        function changeVariation(variation) {
            selectedVariation = variation
        }

        /**
         * function addToCart
         */
        function addToCart(product_id, price, weight, variation) {

            //check token terlebih dahulu
            const token = store.state.auth.token

            console.log(token)

            if (!token) {
                return router.push({ name: 'login' })
            }

            //panggil action addToCart di module cart
            store.dispatch('cart/addToCart', {
                product_id: product_id,
                price: price,
                weight: weight,
                selectedVariation: typeof selectedVariation === 'object' ? '-' : selectedVariation,
                quantity: 1
            })

        }

        return {
            route,
            router,
            store,
            product,
            addToCart,
            selectedVariation,
            changeVariation
            // changeVariation
        }

    }

}
</script>