<template>
  <div class="container py-4">
    <div class="card">
      <div class="card-header">
        <h4 class="mb-0">Cadastro de Novo Afiliado</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="handleSubmit">
          <!-- Username, Nickname -->
          <div class="row mb-3">
            <div class="col-md-6">
              <argon-input
                v-model="form.username"
                type="text"
                label="Username"
                placeholder="Username"
                required
              />
            </div>
            <div class="col-md-6">
              <argon-input
                v-model="form.nickname"
                type="text"
                label="Nickname / Alias"
                placeholder="Nickname / Alias"
                required
              />
            </div>
          </div>
          <!-- Email, Base Percentage -->
          <div class="row mb-3">
            <div class="col-md-6">
              <argon-input
                v-model="form.email"
                type="email"
                label="Email"
                placeholder="Email"
                required
              />
            </div>
            <div class="col-md-6">
              <argon-input
                v-model.number="form.basePercentage"
                type="number"
                label="Base Percentage (%)"
                min="0"
                max="100"
                placeholder="Base Percentage"
                required
              />
            </div>
          </div>

          <hr />
          <h6 class="text-sm text-muted mt-3 mb-2">Referenciadores</h6>

          <!-- Lista de Referenciadores -->
          <div
            v-for="(ref, index) in form.referrals"
            :key="index"
            class="row align-items-center mb-2"
          >
            <!-- Dropdown de Referenciador -->
                  <div class="col-md-5">
                    <select
                      class="form-select form-group"
                      v-model="ref.referrer"
                    >
                      <option disabled value="">Selecione um afiliado</option>
                          <option
                            v-for="option in referrerOptions"
                            :key="option.id"
                            :value="option.id"
                          >
                            {{ option.username }} ({{ option.nickname }})
                          </option>
                    </select>
                  </div>
                  <!-- Percentagem -->
                  <div class="col-md-4">
                    <argon-input
                      v-model.number="ref.percentage"
                      type="number"
                      label="Percentagem (%)"
                      min="0"
                      max="100"
                      placeholder="Percentagem"
                      required
                    />
                  </div>
            <div class="col-md-3 d-flex align-items-end">
              <argon-button
                color="danger"
                size="sm"
                @click="removeReferral(index)"
                class="ms-2"
              >
                Remover
              </argon-button>
            </div>
          </div>

          <argon-button color="secondary" size="sm" @click="addReferral">
            + Adicionar Referenciador
          </argon-button>
          <div class="mt-4">
            <argon-button type="submit" color="success">
              Submeter Formulário
            </argon-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted  } from "vue";
import ArgonInput from "@/components/ArgonInput.vue";
import ArgonButton from "@/components/ArgonButton.vue";
import axios from "axios";
import { getCurrentInstance } from 'vue'
import { useRouter } from 'vue-router'

const internalInstance = getCurrentInstance()
const apiAdress = internalInstance.appContext.config.globalProperties.$apiAdress

const form = reactive({
  username: "",
  nickname: "",
  email: "",
  basePercentage: 0,
  referrals: [],
});
const referrerOptions = ref([]);

const submitted = ref(false);
const router = useRouter();

const addReferral = () => {
  form.referrals.push({ referrer: "", percentage: 0 });
};

const removeReferral = (index) => {
  form.referrals.splice(index, 1);
};

const handleSubmit = () => {
  console.log("Submetendo formulário..." + JSON.stringify(form, null, 2));
  if (form.referrals.length === 0) {
    alert("Por favor, adicione pelo menos um referenciador.");
    return;
  }
  submitted.value = true;
  console.log("Dados enviados:", form);
  axios.post(apiAdress + "/api/cadastroafiliado", {
  username: form.username,
  nickname: form.nickname,
  email: form.email,
  base_percentage: form.basePercentage, 
  referrers: form.referrals.map(r => ({
    referrer_identifier: r.referrer,
    percentage: r.percentage
  }))
}).then(response => {
    if (!response.data.errors) {
      setTimeout(() => {
        router.push({ path: "/dashboard-default" });
      }, 2000);
    }
  })
  .catch(error => {
    console.error("Erro ao enviar dados:", error);
    });
};
const loadReferrers = async () => {
  try {
    const response = await axios.get(apiAdress + "/api/affiliates");
    referrerOptions.value = response.data;
    console.log("Afiliados carregados:", referrerOptions.value);
  } catch (err) {
    console.error("Erro ao carregar afiliados:", err);
  }
};
onMounted(() => {
  loadReferrers();
});
</script>
