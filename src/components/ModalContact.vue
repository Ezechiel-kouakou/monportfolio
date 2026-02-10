<script setup>
import { reactive, ref } from "vue";

defineProps(["isOpen"]);
const emit = defineEmits(["close"]);

const loading = ref(false);
const showSuccessMessage = ref(false);
const lastFirstName = ref(""); 

const form = reactive({
  role: "particulier",
  entreprise: "",
  lastname: "",
  firstname: "",
  email: "",
  message: "",
});

const handleSubmit = async () => {
  loading.value = true;
  lastFirstName.value = form.firstname; 
  
  try {
    const isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";
    
    const apiUrl = isLocal 
      ? "http://localhost/mon-portfolio/traitment.php" 
      : "/traitment.php";

    const response = await fetch(apiUrl, {
      method: "POST",
      headers: { 
        "Content-Type": "application/json",
        "Accept": "application/json" 
      },
      body: JSON.stringify(form),
    });

    const contentType = response.headers.get("content-type");
    
    if (!response.ok || !contentType || !contentType.includes("application/json")) {
        const errorText = await response.text();
        console.error("Réponse du serveur (non-JSON) :", errorText);
        throw new Error("Le serveur n'a pas répondu au format JSON. Vérifiez que traitment.php est bien à la racine du serveur.");
    }

    const result = await response.json();

    if (result.success) {
      showSuccessMessage.value = true;
      setTimeout(() => {
        Object.assign(form, { 
          role: "particulier", 
          entreprise: "", 
          lastname: "", 
          firstname: "", 
          email: "", 
          message: "" 
        });
      }, 500);
    } else {
      throw new Error(result.message || "Erreur lors de l'envoi");
    }
  } catch (error) {
    console.error("Erreur détaillée :", error);
    alert("Désolé, une erreur est survenue : " + error.message);
  } finally {
    loading.value = false;
  }
};
</script>