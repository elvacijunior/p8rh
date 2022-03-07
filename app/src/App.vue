<template>
  <v-app id="inspire">
    <v-app-bar app color="white" flat>
      <v-container class="py-0 fill-height">
        <v-img
          lazy-src="https://picsum.photos/id/11/10/6"
          max-height="50"
          max-width="200"
          src="https://picsum.photos/id/11/500/300"
        ></v-img>
        <v-spacer></v-spacer>
      </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3" style="margin-top: 2vh">
      <v-container>
        <v-row>
          <v-col>
            <v-card elevation="2">
              <v-breadcrumbs :items="breadcrumbs">
                <template v-slot:item="{ item }">
                  <v-breadcrumbs-item
                    :href="item.href"
                    :disabled="item.disabled"
                  >
                    {{ item.text.toUpperCase() }}
                  </v-breadcrumbs-item>
                </template>
              </v-breadcrumbs>
            </v-card>
          </v-col>
        </v-row>
        <v-row style="max-width: 80%; margin: 2vh auto">
          <v-col>
            <v-sheet min-height="70vh" rounded="lg">
              <v-row>
                <v-col style="max-width: 80%; margin: 2vh auto"
                  ><v-banner outlined>
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Fusce suscipit, leo at rutrum tempus, odio justo interdum
                    est, quis blandit augue ipsum a turpis. Integer eu consequat
                    nulla. Sed vel placerat libero. Aenean fringilla lacus et
                    justo bibendum molestie. Fusce scelerisque mollis turpis sit
                    amet commodo. Mauris eget tempor sem. Praesent ut massa
                    aliquet, egestas mauris eget, dapibus nulla. Aliquam euismod
                    lacus vitae ex tempor gravida."
                  </v-banner>
                </v-col>
              </v-row>
              <v-row>
                <v-col style="max-width: 60%; margin: 0 auto">
                  <v-form class="grid-form">
                    <v-file-input
                      label="Anexar Arquivo .json"
                      accept=".json,application/json"
                      v-model="file"
                      outlined
                      dense
                    ></v-file-input>
                    <v-btn
                      :disabled="file == null"
                      color="primary"
                      style="margin-left: 1vw"
                      class="mr-4"
                      @click="createProduct"
                    >
                      ENVIAR
                    </v-btn>
                  </v-form>
                </v-col>
              </v-row>
              <v-row>
                <v-col style="max-width: 80%; margin: 0 auto">
                  <v-data-table
                    :headers="headers"
                    :items="products"
                    :items-per-page="-1"
                    class="elevation-1"
                  >
                    <template v-slot:item="{ item }">
                      <tr>
                        <td>{{ item.title }}</td>
                        <td>{{ item.type }}</td>
                        <td>{{ item.rating }}</td>
                        <td>{{ "R$ " + parseFloat(item.price).toFixed(2) }}</td>
                        <td>{{ item.created_at | formatDate }}</td>
                        <td>
                          <v-btn
                            class="mx-2"
                            fab
                            dark
                            small
                            color="blue"
                            @click="onEditProductClick(item)"
                          >
                            <v-icon dark>mdi-pencil</v-icon>
                          </v-btn>
                          <v-btn
                            class="mx-2"
                            fab
                            dark
                            small
                            color="red"
                            @click="deleteProduct(item.id)"
                          >
                            <v-icon dark>mdi-delete</v-icon>
                          </v-btn>
                        </td>
                      </tr>
                    </template>
                  </v-data-table>
                </v-col>
              </v-row>
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <edit-product
      v-model="showEditDialog"
      :product="editProduct"
    ></edit-product>
  </v-app>
</template>

<script>
import EditProduct from "./components/EditProduct.vue";
import axios from "axios";

export default {
  name: "App",
  components: {
    EditProduct,
  },
  data: () => ({
    file: JSON,
    editProduct: {},
    showEditDialog: false,
    breadcrumbs: [
      {
        text: "HOME",
        disabled: true,
        href: "/",
      },
    ],
    headers: [
      { text: "Title", value: "title", sortable: false },
      { text: "Type", value: "type", sortable: false },
      { text: "Rating", value: "rating", sortable: false },
      { text: "Price", value: "price", sortable: false },
      {
        text: "CreatedAt",
        value: "crated_at",
        sortable: false,
      },
      {
        text: "Actions",
        sortable: false,
      },
    ],
    products: [],
  }),
  mounted() {
    this.getProducts();
  },
  changed() {
    this.getProducts();
  },
  methods: {
    onEditProductClick: function (item) {
      this.editProduct = item;
      this.showEditDialog = true;
    },
    createProduct: function () {
      const formData = new FormData();
      formData.append("fileProduct", this.file);
      console.log(formData);
      axios
        .post("http://localhost/products", formData, {
          "Content-Type": "multipart/form-data",
        })
        .then((response) => {
          console.log(response);
          this.getProducts();
        })
        .catch((err) => console.log(err));
    },
    getProducts: function () {
      axios.get("http://localhost/products").then((response) => {
        console.log(response);
        this.products = response.data.products;
      });
    },
    deleteProduct: function (id) {
      axios.delete("http://localhost/products/" + id).then((response) => {
        console.log(response);
        this.getProducts();
      });
    },
  },
};
</script>

<style scoped>
.grid-form {
  display: flex;
  flex-direction: row;
}
</style>
