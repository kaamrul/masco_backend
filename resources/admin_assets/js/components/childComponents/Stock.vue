<template>
    <div class="col-lg-7">
        <div class="pos-card mb-3">
            <div class="row mx-0">
                <div class="px-0 mb-2 mb-md-0" :class="isAdmin ? 'col-md-3' : 'col-md-6'">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                        </div>
                        <input
                            type="text"
                            placeholder="Search Product"
                            aria-label="Search"
                            id="search"
                            aria-describedby="search"
                            class="form-control pr-4 rounded-right"
                            v-model="searchProduct"
                        />

                        <div
                            v-if="productSearchResultClearIcon"
                            @click="searchProduct = ''"
                        >
                            <i
                                style="cursor: pointer"
                                class="fa fa-close position-absolute p-1 customer-search-cancel"
                            ></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 px-0 pl-md-2" v-if="isAdmin">
                    <div
                        class="language"
                        :class="branchDrawer ? 'highlight' : ''"
                        @click="toggleBranchDrawer"
                    >
                        <p class="language-copy">{{ branchName }}</p>
                        <i
                            class="icon fas fa-chevron-down"
                            :style="{
                                transform: branchDrawer
                                    ? 'rotate(180deg)'
                                    : '',
                            }"
                        ></i>
                    </div>
                    <transition name="slide" style="z-index: 999">
                        <div class="language-drawer" v-if="branchDrawer">
                            <ul
                                v-if="branches.length"
                                class="drawer-list custom-scrollbar"
                            >
                                <li
                                    class="drawer-list-item"
                                    v-for="(branch, index) in branches"
                                    :key="index"
                                >
                                    <div class="drawer-list-name">
                                        <input
                                            @change="updatingBranchId"
                                            type="checkbox"
                                            v-model="branch_id"
                                            :id="index"
                                            :value="branch.id"
                                        />
                                        <label class="my-0" :for="index">{{
                                            branch.name
                                        }}</label>
                                    </div>
                                    <!-- <p class="drawer-list-value">{{ entry.value }}</p> -->
                                </li>
                            </ul>

                            <div
                                class="d-flex justify-content-between align-items-center filter-footer p-3"
                            >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    @click="clearBranchDrawer"
                                >
                                    Clear
                                </button>
                                <button
                                    @click="branchDrawer = false"
                                    type="button"
                                    class="btn btn-success btn-sm"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </transition>
                </div>

                <div class="col-md-3 px-0 pl-md-2">
                    <div
                        class="language"
                        :class="brandDrawer ? 'highlight' : ''"
                        @click="toggleBrandDrawer"
                    >
                        <p class="language-copy">Select Brand</p>
                        <i
                            class="icon fas fa-chevron-down"
                            :style="{
                                transform: brandDrawer
                                    ? 'rotate(180deg)'
                                    : '',
                            }"
                        ></i>
                    </div>
                    <transition name="slide" style="z-index: 999">
                        <div class="language-drawer" v-if="brandDrawer">
                            <ul
                                v-if="brands.length"
                                class="drawer-list custom-scrollbar"
                            >
                                <li
                                    class="drawer-list-item"
                                    v-for="(brand, index) in brands"
                                    :key="index"
                                >
                                    <div class="drawer-list-name">
                                        <input
                                            type="checkbox"
                                            v-model="selectedBrands"
                                            :id="index"
                                            :value="brand"
                                        />
                                        <label class="my-0" :for="index">{{
                                            brand
                                        }}</label>
                                    </div>
                                    <!-- <p class="drawer-list-value">{{ entry.value }}</p> -->
                                </li>
                            </ul>

                            <div
                                class="d-flex justify-content-between align-items-center filter-footer p-3"
                            >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    @click="clearBrandDrawer"
                                >
                                    Clear
                                </button>
                                <button
                                    @click="brandDrawer = false"
                                    type="button"
                                    class="btn btn-success btn-sm"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </transition>
                </div>

                <div class="col-md-3 px-0 pl-md-2">
                    <div
                        class="language"
                        :class="categoryDrawer ? 'highlight' : ''"
                        @click="toggleCategoryDrawer"
                    >
                        <p class="language-copy">Select Category</p>
                        <i
                            class="icon fas fa-chevron-down"
                            :style="{
                                transform: categoryDrawer
                                    ? 'rotate(180deg)'
                                    : '',
                            }"
                        ></i>
                    </div>
                    <transition name="slide" style="z-index: 999">
                        <div class="language-drawer" v-if="categoryDrawer">
                            <ul
                                v-if="categories.length"
                                class="drawer-list custom-scrollbar"
                            >
                                <li
                                    class="drawer-list-item"
                                    v-for="(category, index) in categories"
                                    :key="index"
                                >
                                    <div class="drawer-list-name">
                                        <input
                                            type="checkbox"
                                            v-model="selectedCategories"
                                            :id="category.name"
                                            :value="category.id"
                                        />
                                        <label
                                            class="my-0"
                                            :for="category.name"
                                            >{{ category.name }}</label
                                        >
                                    </div>
                                    <!-- <p class="drawer-list-value">{{ entry.value }}</p> -->
                                </li>
                            </ul>

                            <div
                                class="d-flex justify-content-between align-items-center filter-footer p-3"
                            >
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    @click="clearCategoryDrawer"
                                >
                                    Clear
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-success btn-sm"
                                    @click="categoryDrawer = false"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

        
        <div class="product-section custom-scrollbar position-relative">
            <!-- Preloader -->
                <div v-if="isLoading" class="loader-mask">
                    <div class="loader">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            <!-- Preloader -->

            <div class="row" v-if="stocks.length">
                <div
                    v-for="(stock, index) in stocks"
                    :key="index"
                    class="col-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 mb-75 px-2 standard-product"
                >
                    <a
                        href="#"
                        data-toggle="modal"
                        class="app-color-text"
                        @click.prevent="$emit('addStock', stock)"
                    >
                        <!-- <a
                        href="#"
                        data-toggle="modal"
                        :data-target="`#stock-${stock.id}`"
                        class="app-color-text"
                    > -->
                        <div class="product-card bg-white rounded">
                            <div
                                class="product-img-container image-property"
                            >
                                <img
                                    :src="stock.product.image"
                                    class="img-fluid"
                                />
                            </div>
                            <div
                                class="product-card-content product-content"
                            >
                                <div
                                    class="d-flex justify-content-between product-info"
                                >
                                <div>
                                    <span class="badge badge-secondary" v-if="stock.special_price > 0">
                                       <del> {{ currency }}{{ stock.sale_price }}</del>
                                    </span>
                                    <span class="badge badge-success ml-2">
                                        {{ currency }}{{ stock.special_price > 0 ? stock.special_price : stock.sale_price }}
                                    </span>
                                </div>
                                    
                                    <span class="badge badge-warning">
                                        {{ stock.quantity }}
                                    </span>
                                </div>
                                <div class="position-relative h-100">
                                    <div
                                        class="p-2 h-100 font-weight-bold text-center"
                                    >
                                        <h5 class="product-title">
                                            {{ stock.product.title.length > 25 ? stock.product.title.slice(0, 25) + '...' : stock.product.title }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row text-center" v-else>
                <div class="col-12">
                    <h4>No products available !</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Stock",
    props: ['brands', 'categories', 'currency', 'baseUrl', 'clearMe', 'branches', 'isAdmin'],
    data() {
        return {
            branch_id: [],
            stocks: [],
            selectedBrands: [],
            selectedCategories: [],
            searchProduct: '',
            brandDrawer: false,
            categoryDrawer: false,
            productSearchResultClearIcon: false,
            timeout: null,
            itemsPerPage: 12,
            page: 1,
            isLoading: false,
            branchName: 'Select Branch',
            branchDrawer: false,
            selectedBranchId: ''
        }
    },

    watch: {
        options: {
            handler() {
                this.getStocks();
            },
            deep: true,
        },

        searchProduct(value, oldVal) {
            if (value.length) {
                this.productSearchResultClearIcon = true;
            } else {
                this.productSearchResultClearIcon = false;
            }

            if (value.length >= 2 || oldVal.length >= 2) {
                if (this.timeout) {
                    clearTimeout(this.timeout);
                }
                this.timeout = setTimeout(() => {
                    this.getStocks();
                }, 500);
            }
        },

        selectedBrands(value, oldVal) {
            this.getStocks();
        },

        selectedCategories(value, oldVal) {
            this.getStocks();
        },
    },

    async mounted() {
        if (this.isAdmin && this.selectedBranchId) {
            await this.getStocks();
           
        } else if (!this.isAdmin) {
            await this.getStocks();
            // this.$emit('loadStocks', this.stocks);
        }
    },

    computed: {
        latestCheckedValue() {
            return this.branch_id.length > 0 ? this.branch_id[this.branch_id.length - 1] : null;
        },
    },

    methods: {
        clear() {
            this.branchName = 'Select Branch';
        },

        toggleBranchDrawer(e) {
            this.branchDrawer = !this.branchDrawer;
        },

        clearBranchDrawer(e) {
            this.branchDrawer = !this.branchDrawer;
            this.selectedBranchId = ''
            this.getStocks();
            this.branch_id = []
            this.branchName = 'Select Branch'
            this.$emit('updateBranchToEmpty');
        },

        updatingBranchId() {
            if (this.branch_id.length > 0) {
                const latestCheckedValue = this.latestCheckedValue;

                this.branch_id = this.branch_id.filter(item => item === latestCheckedValue);

                if (latestCheckedValue) {
                    let branch = this.branches.filter(item => item.id === latestCheckedValue);
                    this.branchName = branch[0].name;

                    this.$emit('updateBranch', latestCheckedValue);

                    this.selectedBranchId = latestCheckedValue;

                    this.getStocks();
                } else {
                    this.$emit('updateBranchToEmpty');
                }
            } else {
                this.branchName = 'Select Branch';
                this.$emit('updateBranchToEmpty');
            }
        },

        async getStocks() {
            this.isLoading = true;
            await axios
                .get(
                    `${this.baseUrl}/pos/stocks?per_page=${
                        this.itemsPerPage
                    }&page=${this.page}&search=${
                        this.searchProduct
                    }&brands=${JSON.stringify(
                        this.selectedBrands
                    )}&categories=${JSON.stringify(this.selectedCategories)}&branch_id=${this.selectedBranchId}`
                )
                .then((response) => {
                    this.page = response.data.data.current_page;
                    this.stocks = response.data.data.data;
                    this.$emit('loadStocks', this.stocks);
                    $('.loader-mask').delay(350).fadeOut('slow');
                })
                .catch((error) => {
                    $('.loader-mask').delay(350).fadeOut('slow');
                    //
                });
        },

        toggleBrandDrawer(e) {
            this.brandDrawer = !this.brandDrawer;
        },

        toggleCategoryDrawer(e) {
            this.categoryDrawer = !this.categoryDrawer;
        },

        clearBrandDrawer(e) {
            this.brandDrawer = !this.brandDrawer;
            this.selectedBrands = []
        },

        clearCategoryDrawer(e) {
            this.categoryDrawer = !this.categoryDrawer;
            this.selectedCategories = []
        },
    }
}
</script>

<style scoped>
.loader-mask {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #fff;
    z-index: 99999;
}

.loader {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 50px;
    height: 50px;
    font-size: 0;
    color: #00c9d0;
    display: inline-block;
    margin: -25px 0 0 -25px;
    text-indent: -9999em;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
}
.lead{
  font-size:13px;
}
.loader div {
    background-color: #d9b06a;
    display: inline-block;
    float: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 50px;
    height: 50px;
    opacity: .5;
    border-radius: 50%;
    -webkit-animation: ballPulseDouble 2s ease-in-out infinite;
    animation: ballPulseDouble 2s ease-in-out infinite;
}

.loader div:last-child {
    -webkit-animation-delay: -1s;
    animation-delay: -1s;
}

@-webkit-keyframes ballPulseDouble {
    0%,
    100% {
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    50% {
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}

@keyframes ballPulseDouble {
    0%,
    100% {
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    50% {
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}

.product-img-container{
    width: 100%;
    height: 210px;
    display: flex;
    align-items: center;
    justify-content: center;

}
.product-img-container img{
    height: auto;
    max-height: 170px;
    width: auto;
    max-width: 170px;
}

@media (max-width: 1400px) {
.product-img-container{
    height: 120px;
}
.product-img-container img{
    height: auto;
    max-height: 90px;
    width: auto;
    max-width: 90px;
}
}

@media (max-width: 767px) {

}

@media only screen and (max-width: 991px) and (min-width: 768px){

}
@media (max-width: 480px) {

}
</style>