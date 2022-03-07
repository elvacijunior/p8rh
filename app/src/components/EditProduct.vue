<template>
  <v-row justify="center">
    <v-dialog v-model="show" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Editar Produto</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Title*"
                  v-model="product.title"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Type*"
                  v-model="product.type"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Price*"
                  v-model="product.price"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Rating"
                  v-model="product.rating"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  name="input-7-1"
                  label="Description"
                  v-model="product.description"
                  hint="Hint text"
                ></v-textarea>
              </v-col>
            </v-row>
          </v-container>
          <small>*campos obrigatórios</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="cancelEdit()">
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="updateProduct()"
            :disabled="
              this.product.title.length < 1 ||
              this.product.type.length < 1 ||
              this.product.price.length < 1
            "
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import axios from "axios";
export default {
  name: "EditProduct",
  props: {
    product: Object,
    value: Boolean,
  },
  data: () => {
    return {
      editedProduct: Object,
    };
  },
  computed: {
    show: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("input", value);
      },
    },
  },
  methods: {
    updateProduct: function () {
      if (
        this.product.title.length > 0 &&
        this.product.type.length > 0 &&
        this.product.price.length > 0
      )
        axios
          .put("http://localhost/products/" + this.product.id, this.product)
          .then((response) => {
            console.log(response);
            this.show = false;
          });
    },
    cancelEdit: function () {
      this.show = false;
      window.location.reload();
    },
  },
};
</script>
