<template>
  <div>
    <v-dialog
      max-width="450"
      v-model="authDialog"
      persistent
    >
      <v-card>
        <v-toolbar flat color="primary">
          <v-card-title class="text-white">Login</v-card-title>
        </v-toolbar>
        <v-form lazy-validation ref="form" class="pa-4">
          <v-card-text class="text-center text-danger">Kindly login to continue...</v-card-text>
          <v-text-field
            outlined
            dense
            :rules="[(v) => !!v || 'Please provide your email address']"
            v-model="form.email"
          ></v-text-field>
        </v-form>
        <v-card-actions
          class="d-flex justify-content-end"
        >
          <v-btn
            outlined
            color="error"
            @click="closeModal"
          >Close</v-btn>
          <v-btn
            color="primary"
            @click="$refs.form.validate() ? loginUser() : null"
            :loading="loading"
          >Submit</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import Toasts from "../utils/toast";
    export default {
        props: {
            authDialog: {
                Boolean,
                default: false,
            }
        },

        name: "Authenticate",

        data() {
            return {
                loading: false,
                form: {},
                toast: new Toasts(),
            }
        },

        methods: {
            ...mapActions('auth', [
                'login_user'
            ]),

            closeModal() {
                this.$parent.authDialog = false;
            },

            async loginUser() {
                this.loading = true;
                try {
                    const response = await this.login_user(this.form);
                    this.toast.successMessage(response);
                    this.closeModal();
                    this.loading = false;
                } catch (error) {
                    this.loading = false;
                    this.toast.errorMessage(error);
                }
            }
        }
    }
</script>

<style scoped>

</style>