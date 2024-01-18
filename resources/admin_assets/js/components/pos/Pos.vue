<template>
    <div class="position-relative">
        <!-- Preloader -->
            <div v-if="isLoading" class="loader-mask">
                <div class="loader">
                    <div></div>
                    <div></div>
                </div>
            </div>
        <!-- Preloader -->
        
        <div class="row">
            <Stock v-if="customerTypes.length"
                :isAdmin="isAdmin"
                :clearMe="clearMe"
                :currency="currency"
                :brands="brands"
                :categories="categories"
                :baseUrl="baseUrl"
                @addStock="addStock"
                @loadStocks="loadStocks"
                :branches="branches"
                @updateBranchToEmpty="updateBranchToEmpty"
                @updateBranch="updateBranch"
            />

            <div class="col-lg-5 pl-5">
                <div class="pos-card">
                    <Customer
                        :clearMe="clearMe"
                        :baseUrl="baseUrl"
                        @addCustomer="addCustomer"
                        :countries="countries"
                        :genders="genders"
                        :customerTypes="customerTypes"
                    />

                    <div
                        id="cart-section-2"
                        class="cart-items-wrapper h-100 custom-scrollbar"
                    >
                        <template v-if="selectedStocks.length">
                            <div
                                class="cart-item-container py-1 border-bottom"
                                v-for="(stock, index) in selectedStocks"
                                :key="index"
                            >
                                <div class="row mx-0 px-1 cart-item">
                                    <div
                                        class="col-md-6 cart-item-btn align-self-center"
                                    >
                                        <span class="align-self-center">
                                            {{ stock.title }}</span
                                        >
                                    </div>
                                    <div class="col-md-3">
                                        <div class="qty-input">
                                            <button
                                                class="qty-count qty-count--minus"
                                                data-action="minus"
                                                type="button"
                                                @click.prevent="
                                                    minusStock(stock.stock_id)
                                                "
                                            >
                                                -
                                            </button>
                                            <input
                                                class="product-qty"
                                                type="number"
                                                :value="stock.quantity"
                                                @input="
                                                    updateStock(
                                                        stock.stock_id,
                                                        $event.target.value
                                                    )
                                                "
                                            />
                                            <button
                                                class="qty-count qty-count--add"
                                                data-action="add"
                                                type="button"
                                                @click.prevent="
                                                    plusStock(stock.stock_id)
                                                "
                                            >
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-3 d-flex cart-calculatedPrice"
                                    >
                                        <div class="align-self-center">
                                            <span
                                                >{{ currency
                                                }}{{ stock.price }}</span
                                            >
                                        </div>
                                        <div class="align-self-center ml-2">
                                            <a
                                                href="#"
                                                class="text-danger"
                                                @click.prevent="removeStock(index)"
                                            >
                                                <i
                                                    class="fa-solid fa-trash-can"
                                                ></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-2 d-none changeQtyDiv">
                                        <div class="d-flex justify-content-center">
                                            <label class="col-sm-3 col-form-label"
                                                >Quantity:</label
                                            >
                                            <input
                                                type="number"
                                                name="quantity[]"
                                                value="1"
                                                class="form-control col-sm-4 px-1 input-qty"
                                                min="1"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div v-else class="text-center p-3">
                            <h4>Cart is empty !</h4>
                        </div>
                    </div>

                    <div id="cart-section-3" class="">
                        <div
                            class="row mx-0 px-3 py-2 font-weight-bold border-top border-bottom"
                        >
                            <div class="col-6 p-0">Sub Total</div>
                            <div class="col-6 p-0 text-right">
                                {{ currency }}{{ subtotal }}
                            </div>
                        </div>

                        <div class="row mx-0 px-3 py-2 border-bottom">
                            <div class="col-6 p-0">VAT/Tax</div>
                            <div class="col-6 p-0 text-right">
                                {{ currency }}{{ vat }}
                            </div>
                        </div>

                        <div
                            id="pop_mouse1"
                            class="row mx-0 px-3 py-2 border-bottom"
                        >
                            <div class="col-6 p-0 d-flex align-items-center">
                                Packaging Charge
                                <i
                                    @click="togglePackagingChargeEdit"
                                    style="cursor: pointer"
                                    class="fa fa-edit packaging-charge-popover ml-2"
                                ></i>
                            </div>
                            <div class="col-3 p-0">
                                <input
                                    @input="updatePackagingCharge"
                                    @keyup.enter="togglePackagingChargeEdit"
                                    v-if="packagingChargeEdit"
                                    type="number"
                                    class="form-control px-1"
                                    v-model="packagingCharge"
                                />
                            </div>
                            <div class="col-3 p-0 d-flex align-items-center">
                                <div class="amount-div">
                                    <span>
                                        {{ currency
                                        }}{{
                                            parseFloat(
                                                packagingChargeAmount
                                            ).toFixed(2)
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            id="pop_mouse2"
                            class="row mx-0 px-3 py-2 border-bottom"
                        >
                            <div class="col-6 p-0 d-flex align-items-center">
                                Delivery Charge
                                <i
                                    @click="toggleDeliveryChargeEdit"
                                    style="cursor: pointer"
                                    class="fa fa-edit packaging-charge-popover ml-2"
                                ></i>
                            </div>
                            <div class="col-3 p-0">
                                <input
                                    @input="updateDeliveryCharge"
                                    @keyup.enter="toggleDeliveryChargeEdit"
                                    v-if="deliveryChargeEdit"
                                    type="number"
                                    class="form-control px-1"
                                    v-model="deliveryCharge"
                                />
                            </div>
                            <div class="col-3 p-0 d-flex align-items-center">
                                <div class="amount-div">
                                    <span>
                                        {{ currency
                                        }}{{
                                            parseFloat(
                                                deliveryChargeAmount
                                            ).toFixed(2)
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div id="pop_mouse3" class="row mx-0 px-3 py-2">
                            <div class="col-6 p-0 d-flex align-items-center">
                                Discount on Subtotal
                                <i
                                    @click="toggleDiscountEdit"
                                    style="cursor: pointer"
                                    class="fa fa-edit discount-on-subtotal-popover ml-2"
                                ></i>
                            </div>
                            <div class="col-3 p-0">
                                <input
                                    @input="updateDiscount"
                                    @keyup.enter="toggleDiscountEdit"
                                    v-if="discountEdit"
                                    type="number"
                                    class="form-control px-1"
                                    v-model="discount"
                                />
                            </div>
                            <div class="col-3 p-0 d-flex align-items-center">
                                <div class="amount-div">
                                    <span>
                                        {{ currency
                                        }}{{
                                            parseFloat(discountAmount).toFixed(2)
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0 px-3 py-2 border-top border-bottom">
                            <div class="col-6 p-0">
                                <span class="font-weight-bold"> Total </span>
                                <!-- <span>
                                    <span>Tex included</span>
                                </span -->
                                >
                            </div>
                            <div class="col-3 p-0 text-center">
                                <div role="group" class="btn-group dropright"></div>
                            </div>
                            <div class="col-3 p-0 text-right">
                                <span>
                                    <a
                                        data-toggle="modal"
                                        data-target="#tax-edit-modal"
                                        href="#"
                                        class=""
                                    >
                                        <i
                                            class="la la-edit discount-all-item-popover"
                                        ></i>
                                    </a>
                                </span>
                                <span class="col-6 p-0 font-weight-bold text-right">
                                    {{ currency }}{{ total }}
                                </span>
                            </div>
                        </div>

                        <div class="p-3 d-flex justify-content-center">
                            <button
                                :disabled="
                                    !selectedStocks.length ||
                                    !selectedCustomer.full_name
                                "
                                data-toggle="modal"
                                data-target="#pay"
                                href="#"
                                class="btn cart-pay-btn"
                            >
                                <i class="fa-solid fa-money-bill-1 mr-2"></i> Pay
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment modal -->
            <div
                ref="paymentModal"
                class="modal fade"
                id="pay"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <i class="fa-solid fa-money-bill-1 mr-2"></i>
                                Make Payment
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row mx-0 modal-content-row">
                                <div
                                    class="col-12 col-md-6 cart-border-right text-center"
                                >
                                    <div
                                        class="horizontal-scroll"
                                        id="printableArea"
                                    >
                                        <h5 class="text-center mb-4">
                                            Sales Details
                                        </h5>
                                        <div class="invoiceLogo text-center">
                                            <img
                                                src="../../../../../resources/images/logo.png"
                                                width="100"
                                                alt=""
                                                class="img-fluid"
                                            />
                                        </div>
                                        <div>
                                            <div
                                                class="text-center header-line-height"
                                            >
                                                <!-- <small
                                                    class="text-center font-weight-bold"
                                                >
                                                    POS
                                                </small> -->
                                                <br />
                                                <small class="text-center">
                                                    {{ date }}
                                                </small>
                                                <br />
                                                <small class="text-center">
                                                    Sales Receipt
                                                </small>
                                                <br />
                                                <small class="text-left">
                                                    Sold By: {{ authUserName }}
                                                </small>
                                                <br />
                                                <small>
                                                    <span>
                                                        <span>
                                                            Sold To:
                                                            {{
                                                                selectedCustomer.full_name
                                                            }}
                                                            {{
                                                                selectedCustomer.phone
                                                            }}
                                                        </span>
                                                    </span>
                                                </small>
                                                <small
                                                    class="text-left invoice-show"
                                                    style="display: none"
                                                >
                                                    Invoice Number:
                                                </small>
                                            </div>

                                            <div class="invoice-table">
                                                <table
                                                    class="table product-card-font"
                                                >
                                                    <thead class="border-top-0">
                                                        <tr>
                                                            <th
                                                                class="cart-summary-table text-left"
                                                            >
                                                                Items
                                                            </th>
                                                            <th
                                                                class="cart-summary-table text-center"
                                                            >
                                                                Qty
                                                            </th>
                                                            <th
                                                                class="cart-summary-table text-right"
                                                            >
                                                                Price
                                                            </th>
                                                            <th
                                                                class="cart-summary-table text-right"
                                                            >
                                                                Total
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="(
                                                                stock, index
                                                            ) in selectedStocks"
                                                            :key="index"
                                                        >
                                                            <td
                                                                class="cart-summary-table text-left"
                                                            >
                                                                {{ stock.title }}
                                                                <!-- <br> <span>( Black,S )</span> -->
                                                            </td>
                                                            <td
                                                                class="cart-summary-table"
                                                            >
                                                                {{ stock.quantity }}
                                                            </td>
                                                            <td
                                                                class="text-right cart-summary-table"
                                                            >
                                                                {{ currency
                                                                }}{{ stock.price }}
                                                            </td>

                                                            <td
                                                                class="text-right cart-summary-table"
                                                            >
                                                                {{ currency
                                                                }}{{
                                                                    stock.price *
                                                                    stock.quantity
                                                                }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td
                                                                colspan="3"
                                                                class="cart-summary-table font-weight-bold text-left"
                                                            >
                                                                Sub Total
                                                            </td>
                                                            <td
                                                                class="text-right cart-summary-table"
                                                            >
                                                                {{ currency
                                                                }}{{ subtotal }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                colspan="3"
                                                                class="cart-summary-table font-weight-bold text-left"
                                                            >
                                                                Collection
                                                            </td>
                                                            <td
                                                                class="text-right cart-summary-table"
                                                            >
                                                                {{ currency
                                                                }}{{ collection }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                colspan="3"
                                                                class="cart-summary-table font-weight-bold text-left"
                                                            >
                                                                Due
                                                            </td>
                                                            <td
                                                                class="text-right cart-summary-table"
                                                            >
                                                                {{ currency
                                                                }}{{ due }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                colspan="3"
                                                                class="cart-summary-table font-weight-bold text-left"
                                                            >
                                                                Total <small>({{ totalInWord }})</small>
                                                            </td>
                                                            <td
                                                                class="text-right cart-summary-table"
                                                            >
                                                                {{ currency
                                                                }}{{ total }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        :disabled="!orderPlaced"
                                        @click="printMe"
                                        class="btn btn-primary mt-4 ms-2"
                                    >
                                        <i class="ti-printer mr-2"></i>
                                        Print
                                    </button>
                                </div>

                                <div
                                    id="js-payment"
                                    class="col-12 col-md-6 d-flex align-items-center justify-content-center"
                                >
                                    <div
                                        v-if="orderPlaced"
                                        id="js-payment-action"
                                        class="payment-action"
                                    >
                                        <div class="row mx-0 mt-2 no-gutters">
                                            <div class="col-12">
                                                <span>
                                                    <div
                                                        class="p-3 d-flex justify-content-center"
                                                    >
                                                        <button
                                                            href="#"
                                                            class="btn"
                                                            style="
                                                                padding: 7px 60px;
                                                                background: var(
                                                                    --color-deep-secondary
                                                                );
                                                                color: var(
                                                                    --color-white
                                                                );
                                                                border: 1px solid
                                                                    var(
                                                                        --color-deep-secondary
                                                                    );
                                                                font-size: 22px;
                                                                font-weight: 800;
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-check mr-2"
                                                            ></i>
                                                            Order Placed !!
                                                        </button>
                                                    </div>
                                                    <h3
                                                        class="mt-2"
                                                        style="
                                                            color: var(
                                                                --color-deep-secondary
                                                            );
                                                            text-align: center;
                                                        "
                                                    >
                                                        Thank You !
                                                    </h3>
                                                    <div
                                                        class="p-3 d-flex justify-content-center"
                                                    >
                                                        <span>
                                                            <div
                                                                class="p-3 d-flex justify-content-center"
                                                            >
                                                                <a
                                                                    @click.prevent="
                                                                        closeOrder
                                                                    "
                                                                    href="#"
                                                                    class="btn cart-pay-btn"
                                                                >
                                                                    Close
                                                                </a>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-center"
                                        v-else-if="somethingWrong"
                                        style="width: 90%"
                                    >
                                        <div
                                            class="alert alert-danger"
                                            role="alert"
                                        >
                                            Something went wrong ! please try again.
                                        </div>
                                        <div
                                            class="p-3 d-flex justify-content-center"
                                        >
                                            <span>
                                                <div
                                                    class="p-3 d-flex justify-content-center"
                                                >
                                                    <a
                                                        @click.prevent="closeOrder"
                                                        href="#"
                                                        class="btn cart-pay-btn"
                                                    >
                                                        Close
                                                    </a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>

                                    <dev v-else>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="payments_div">
                                                    <div
                                                        class="col-md-12 mb-3"
                                                        v-for="(
                                                            payment, index
                                                        ) in payments"
                                                        :key="index"
                                                    >
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div
                                                                    v-if="
                                                                        payments.length >
                                                                        1
                                                                    "
                                                                    @click.prevent="
                                                                        removeRow(
                                                                            index
                                                                        )
                                                                    "
                                                                    class="row d-flex flex-row-reverse"
                                                                    style="
                                                                        position: absolute;
                                                                        right: 0;
                                                                        top: 12px;
                                                                        cursor: pointer;
                                                                    "
                                                                >
                                                                    <i
                                                                        type="button"
                                                                        class="btn btn-box-tool mt-n3 remove"
                                                                        ><i
                                                                            class="fa fa-times fa-2x"
                                                                        ></i
                                                                    ></i>
                                                                </div>

                                                                <div class="row">
                                                                    <div
                                                                        class="col-md-4"
                                                                    >
                                                                        <div
                                                                            class=""
                                                                        >
                                                                            <label
                                                                                >Amount</label
                                                                            >
                                                                            <input
                                                                                type="number"
                                                                                class="form-control text-right payment"
                                                                                placeholder="Amount"
                                                                                v-model="
                                                                                    payment.amount
                                                                                "
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-md-4"
                                                                    >
                                                                        <div
                                                                            class=""
                                                                        >
                                                                            <label
                                                                                >Transaction
                                                                                Id</label
                                                                            >
                                                                            <input
                                                                                type="text"
                                                                                class="form-control text-right payment"
                                                                                placeholder="Transaction Id"
                                                                                v-model="
                                                                                    payment.transaction_id
                                                                                "
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-md-4"
                                                                    >
                                                                        <div
                                                                            class=""
                                                                        >
                                                                            <label
                                                                                >Payment
                                                                                Type</label
                                                                            >
                                                                            <select
                                                                                v-model="
                                                                                    payment.type
                                                                                "
                                                                                class="form-control"
                                                                                id="payment_type_1"
                                                                                name="payment_type_1"
                                                                            >
                                                                                <option
                                                                                    value=""
                                                                                >
                                                                                    Select
                                                                                    One
                                                                                </option>
                                                                                <option
                                                                                    v-for="(
                                                                                        paymentMethod,
                                                                                        index
                                                                                    ) in paymentMethods"
                                                                                    :key="
                                                                                        index
                                                                                    "
                                                                                    :value="
                                                                                        paymentMethod
                                                                                    "
                                                                                    :selected="
                                                                                        paymentMethod ==
                                                                                        payment.type
                                                                                    "
                                                                                >
                                                                                    {{
                                                                                        paymentMethod
                                                                                    }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div
                                                        class="col-md-12 d-flex justify-content-center"
                                                    >
                                                        <button
                                                            @click.prevent="
                                                                addNewRow
                                                            "
                                                            type="button"
                                                            class="btn btn-outline-primary btn-fw"
                                                            id="add_payment_row"
                                                        >
                                                            Add Payment Row
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <label
                                                                for="payment_note_1"
                                                                >Note</label
                                                            >
                                                            <textarea
                                                                v-model="note"
                                                                type="text"
                                                                class="form-control"
                                                                id="payment_note_1"
                                                                name="payment_note_1"
                                                                placeholder=""
                                                            ></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            id="js-payment-action"
                                            class="payment-action"
                                        >
                                            <div class="row mx-0 mt-2 no-gutters">
                                                <div class="col-12">
                                                    <hr class="custom-margin" />
                                                    <span>
                                                        <div
                                                            class="p-3 d-flex justify-content-center"
                                                        >
                                                            <button
                                                                :disabled="
                                                                    !readyToPlaceOrder
                                                                "
                                                                @click.prevent="
                                                                    createOrder
                                                                "
                                                                href="#"
                                                                class="btn cart-pay-btn"
                                                            >
                                                                <i
                                                                    class="fa fa-check mr-2"
                                                                ></i>
                                                                Done Payment
                                                            </button>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </dev>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <audio id="beepAudio">
                <source src="../../../audio/pos.wav" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>

            <audio id="errorAudio">
                <source src="../../../audio/error.mp3" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>

        </div>
    </div>
</template>

<script>
import print from "print-js";
import Stock from "../childComponents/Stock.vue";
import Customer from "../childComponents/Customer.vue";

export default {
    name: "Pos",
    components: {
        Stock,
        Customer,
    },
    data() {
        return {
            branch_id: '',
            customerTypes: [],
            paymentMethods: [],
            payments: [
                {
                    type: "",
                    amount: 0,
                    transaction_id: "",
                },
            ],
            selectedStocks: [],
            selectedCustomer: {},
            branches: [],
            brands: [],
            categories: [],
            stocks: [],
            baseUrl: window.BASE_URL,
            timeout: null,
            itemsPerPage: 10,
            page: 1,
            vatRate: 0, // 20%
            deliveryCharge: 0,
            packagingCharge: 0,
            discount: 0,
            note: "",
            orderPlaced: false,
            readyToPlaceOrder: true,
            authUserName: "",
            date: "",
            packagingChargeEdit: false,
            deliveryChargeEdit: false,
            discountEdit: false,
            currency: "",
            countries: [],
            genders: [],
            clearMe: false,
            packagingChargeAmount: 0,
            deliveryChargeAmount: 0,
            discountAmount: 0,
            somethingWrong: false,
            isAdmin: false,
            isLoading: true,
        };
    },

    async mounted() {
        //$('#pay').modal({backdrop: 'static', keyboard: false});
        await this.getInitialData();

        $(this.$refs.paymentModal).on(
            "hidden.bs.modal",
            this.doSomethingOnHidden
        );
    },

    computed: {
        subtotal() {
            return this.selectedStocks
                .reduce((total, item) => total + item.price * item.quantity, 0)
                .toFixed(2);
        },

        vat() {
            return (
                parseFloat(this.subtotal) * parseFloat(this.vatRate) / 100 // ($percentage / 100) * $totalWidth;
            ).toFixed(2);
        },

        totalInWord() {
            let word = this.numberToWordConverter((
                parseFloat(this.subtotal) +
                parseFloat(this.vat) +
                this.deliveryChargeAmount +
                this.packagingChargeAmount -
                this.discountAmount
            ).toFixed(0));

            return word.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
        },

        total() {
            return (
                parseFloat(this.subtotal) +
                parseFloat(this.vat) +
                this.deliveryChargeAmount +
                this.packagingChargeAmount -
                this.discountAmount
            ).toFixed(2);
        },

        collection() {
            let total = 0;

            for (const item of this.payments) {
                const amount = parseFloat(item.amount);

                if (amount < 0) {
                    item.amount = 0;

                    return total.toFixed(2);
                }

                if (!isNaN(amount)) {
                    if (item.amount > 0 && item.type == "") {
                        this.readyToPlaceOrder = false;
                    } else {
                        this.readyToPlaceOrder = true;
                    }

                    if (amount > this.total) {
                        alert("Collection cannot be greater than total");
                        item.amount = 0;
                    } else {
                        total += amount;
                    }
                }
            }

            return total.toFixed(2);
        },

        due() {
            return (parseFloat(this.total) - this.collection).toFixed(2);
        },
    },

    methods: {
        numberToWordConverter (num){
            var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
            var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

            if ((num = num.toString()).length > 9) return 0;

            let n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return; var str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';

            return str;
        },

        loadStocks(stocks) {
            this.stocks = stocks;
        },

        addCustomer(value) {
            this.selectedCustomer = value;
        },

        updateBranch(value) {
            this.branch_id = value;
        },

        updateBranchToEmpty() {
            this.branch_id = '';
        },

        getFormat(price) {
            return window.formatPrice(price);
        },

        updatePackagingCharge() {
            const parsedValue = parseFloat(this.packagingCharge);

            if (!isNaN(parsedValue) && parsedValue >= 0) {
                this.packagingChargeAmount = parsedValue;
            } else if (parsedValue < 0) {
                this.packagingCharge = 0;
                this.packagingChargeAmount = 0;
            } else {
                this.packagingChargeAmount = 0;
            }

            this.$forceUpdate();
        },

        updateDeliveryCharge() {
            // this.deliveryCharge =
            //     !isNaN(this.deliveryCharge) && this.deliveryCharge > 0
            //         ? this.deliveryCharge
            //         : 0;
            const parsedValue = parseFloat(this.deliveryCharge);

            if (!isNaN(parsedValue) && parsedValue >= 0) {
                this.deliveryChargeAmount = parsedValue;
            } else if (parsedValue < 0) {
                this.deliveryCharge = 0;
                this.deliveryChargeAmount = 0;
            } else {
                this.deliveryChargeAmount = 0;
            }

            this.$forceUpdate();
        },

        updateDiscount() {
            const parsedValue = parseFloat(this.discount);

            if (!isNaN(parsedValue) && parsedValue >= 0) {
                if (parsedValue > this.total) {
                    alert("Discount can not grater than total");
                    this.discount = 0;
                    this.discountAmount = 0;
                    return;
                }

                this.discountAmount = parsedValue;
            } else if (parsedValue < 0) {
                this.discount = 0;
                this.discountAmount = 0;
            } else {
                this.discountAmount = 0;
            }

            this.$forceUpdate();
        },

        togglePackagingChargeEdit() {
            this.packagingChargeEdit = !this.packagingChargeEdit;
        },

        toggleDeliveryChargeEdit() {
            this.deliveryChargeEdit = !this.deliveryChargeEdit;
        },

        toggleDiscountEdit() {
            this.discountEdit = !this.discountEdit;
        },

        doSomethingOnHidden() {
            if (this.orderPlaced) {
                this.clear();
            }
        },

        printMe() {
            printJS({
                printable: "printableArea",
                type: "html",
                targetStyles: ["*"],
            });
        },

        closeOrder() {
            this.clear();
            $("#pay").modal("hide");
        },

        clear() {
            this.somethingWrong = false;
            this.payments = [
                {
                    type: "",
                    amount: 0,
                    transaction_id: "",
                },
            ],
            this.selectedStocks = [],
            this.selectedCustomer = {},
            this.deliveryCharge = 0,
            this.packagingCharge = 0,
            this.discount = 0,
            this.note = '',
            this.branch_id = '',
            this.orderPlaced = false,
            this.authUserName = '',
            this.date = '';
        },

        async createOrder() {
            let data = {
                stocks: this.selectedStocks,
                customerId: this.selectedCustomer.id,
                payments: this.payments,
                total: this.total,
                subTotal: this.subtotal,
                vat: this.vat,
                discount: this.discount,
                deliveryCharge: this.deliveryCharge,
                packagingCharge: this.packagingCharge,
                due: this.due,
                collection: this.collection,
                note: this.note,
                branch_id: this.branch_id,
            };

            await axios
                .post(`${this.baseUrl}/pos/order`, data)
                .then((response) => {
                    if (response.data.status == "success") {
                        this.orderPlaced = true;
                        this.clearMe = true;
                    }
                })
                .catch((error) => {
                    if (error?.response?.data?.status == "failed") {
                        this.somethingWrong = true;
                        this.clearMe = true;
                    }
                    // if (error?.response?.status === 422) {
                    //     this.validationErrors = error?.response?.data?.errors
                    // } else {
                    //     this.$toast.show(error?.response?.data?.message, {
                    //         type: 'error',
                    //     });
                    // }
                });
        },

        addNewRow() {
            this.payments.push({
                type: "",
                amount: 0,
                transaction_id: "",
            });
        },

        removeRow(index) {
            if (index >= 0 && index < this.payments.length) {
                this.payments.splice(index, 1);
            }
        },

        addStock(stock) {
            var tempStock = {
                product_id: stock.product_id,
                title: stock.product.title,
                stock_id: stock.id,
                quantity: 1,
                price: parseFloat(
                    stock.special_price > 0
                        ? stock.special_price
                        : stock.sale_price
                ),
            };

            var isExists = this.selectedStocks.filter(function (item) {
                return item.stock_id == stock.id;
            });

            if (isExists.length) {
                return this.selectedStocks.filter(function (item) {
                    if (item.stock_id == stock.id) {
                        if (stock.quantity <= item.quantity) {
                            document.getElementById('errorAudio').play();
                            alert("Out of stock");
                            return;
                        }

                        document.getElementById('beepAudio').play();
                        return item.quantity++;
                    }
                });
            }

            document.getElementById('beepAudio').play();
            this.selectedStocks.push(tempStock);
        },

        plusStock(stock_id) {
            var currentStock = this.stocks.filter(function (item) {
                return item.id == stock_id;
            });

            this.selectedStocks.filter(function (item) {
                if (item.stock_id == stock_id) {
                    if (currentStock[0].quantity <= item.quantity) {
                        document.getElementById('errorAudio').play();
                        alert("Out of stock");
                        return;
                    }

                    document.getElementById('beepAudio').play();
                    return item.quantity++;
                }
            });
        },

        minusStock(stock_id) {
            var currentStock = this.selectedStocks.filter(function (item) {
                return item.stock_id == stock_id;
            });

            if (currentStock[0].quantity == 1) {
                document.getElementById('errorAudio').play();
                return;
            }

            return this.selectedStocks.filter(function (item) {
                if (item.stock_id == stock_id) {
                    document.getElementById('beepAudio').play();
                    return item.quantity--;
                }
            });
        },

        updateStock(stock_id, quantity) {
            var currentStock = this.stocks.filter(function (item) {
                return item.id == stock_id;
            });

            this.selectedStocks = this.selectedStocks.map(function (item) {
                if (item.stock_id == stock_id) {
                    if (currentStock[0].quantity < quantity) {
                        document.getElementById('errorAudio').play();
                        alert("Out of stock");
                        return item;
                    } else {
                        document.getElementById('beepAudio').play();
                        item.quantity =
                            !isNaN(quantity) && quantity > 0
                                ? quantity
                                : item.quantity;
                    }
                }

                document.getElementById('errorAudio').play();
                return item;
            });
        },

        removeStock(index) {
            if (index >= 0 && index < this.selectedStocks.length) {
                this.selectedStocks.splice(index, 1);
            }
        },

        async getInitialData() {
            await axios
                .get(`${this.baseUrl}/pos/initial-data`)
                .then((response) => {
                    this.isAdmin = response.data.isAdmin;
                    this.brands = response.data.brands;
                    this.categories = response.data.categories;
                    this.paymentMethods = response.data.paymentMethods;
                    this.vatRate = response.data.vatAmount;
                    this.authUserName = response.data.authUserName;
                    this.date = response.data.date;
                    this.currency = response.data.currency;
                    this.genders = response.data.genders;
                    this.countries = response.data.countries;
                    this.customerTypes = response.data.customerTypes;
                    this.branches = response.data.branches;

                    this.isLoading = false;
                })
                .catch((error) => {
                    this.isLoading = false;
                });
        },
    },
};
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
</style>
