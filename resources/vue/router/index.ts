import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/game",
      name: "game",
      component: () => import("../views/GameView.vue"),
    },
    {
      path: "/irdya",
      name: "irdya",
      component: () => import("../views/CharacterLandingView.vue"),
    },
  ],
});

export default router;
