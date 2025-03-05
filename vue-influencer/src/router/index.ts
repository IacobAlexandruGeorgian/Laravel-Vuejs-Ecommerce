import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import TheLayout from '../pages/TheLayout.vue'
import HomePage from '../pages/HomePage.vue'
import LoginPage from '../pages/LoginPage.vue'
import RegisterPage from '../pages/RegisterPage.vue'
import RankingsPage from '@/pages/RankingsPage.vue'
import StatsPage from '@/pages/StatsPage.vue'

const routes: Array<RouteRecordRaw> = [
  {path: '/login', component: LoginPage},
  {path: '/register', component: RegisterPage},
  {path: '/', component: TheLayout, children: [
    {path: '', component: HomePage},
    {path: 'rankings', component: RankingsPage},
    {path: 'stats', component: StatsPage}     
  ]},
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
