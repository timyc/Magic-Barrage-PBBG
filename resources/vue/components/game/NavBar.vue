<script setup lang="ts">
import { ref } from "vue";
import News from "./nav/News.vue";
import Wiki from "./nav/Wiki.vue";
import Ranking from "./nav/Ranking.vue";
import Social from "./nav/Social.vue";
import Code from "./nav/Code.vue";
import Store from "./nav/Store.vue";

const display = ref("none");
const newsRef = ref(null as unknown as typeof News);
const wikiRef = ref(null as unknown as typeof Wiki);
const rankingRef = ref(null as unknown as typeof Ranking);
const socialRef = ref(null as unknown as typeof Social);
const codeRef = ref(null as unknown as typeof Code);
const storeRef = ref(null as unknown as typeof Store);

function toggleMenu() {
	if (display.value === "none") {
		display.value = "block";
	} else {
		display.value = "none";
	}
}

function openNews() {
	newsRef.value.visible = true;
}

function openWiki() {
	wikiRef.value.visible = true;
}

function openRanking() {
	rankingRef.value.visible = true;
}

function openSocial() {
	socialRef.value.visible = true;
}

function openCode() {
	codeRef.value.open();
}

function openStore() {
	storeRef.value.visible = true;
}
</script>

<template>
	<el-header class="navbar-wrap">
		<span id="menu" @click="toggleMenu">Menu</span>
		<ul class="navigation">
			<li @click="openNews">
				News
			</li>
			<li @click="openWiki">
				Wiki
			</li>
			<li @click="openRanking">
				Ranking
			</li>
			<li @click="openSocial">
				Social
			</li>
			<li @click="openCode">
				Code
			</li>
			<li @click="openStore">
				Store
			</li>
		</ul>
	</el-header>
	<News ref="newsRef" />
	<Wiki ref="wikiRef" />
	<Ranking ref="rankingRef" />
	<Social ref="socialRef" />
	<Code ref="codeRef" />
	<Store ref="storeRef" />
</template>

<style scoped>
.navbar-wrap {
	height: 154px;
	padding: 0;
	margin: 0;
	display: flex;
	justify-content: center;
	width: 100%;
}

#menu {
	display: none;
	cursor: pointer;
	font-family: candara;
	font-size: 1.4rem;
	text-transform: uppercase;
	color: #ead796;
}

ul {
	list-style-type: disc;
	margin: 0;
}

ol,
ul,
li {
	color: #5a4f4c;
	font-size: 1.4rem;
	line-height: 1.63 !important;
}

ul,
ol,
dl {
	font-size: 100%;
	line-height: 1;
}

.navigation {
	display: inline-block;
	padding-left: 0px;
}

.navigation li {
	padding: 28px 37px;
	display: inline-block;
	position: relative;
	background: url(/img/ui/header.png) center top no-repeat;
	cursor: pointer;
}

.navigation li:first-child {
	background-position: 0 0;
	height: 95px;
	margin-left: 0;
}

.navigation li:nth-child(2) {
	height: 40px;
	background-position: -309px 0;
}

.navigation li:nth-child(3) {
	height: 40px;
	background-position: -437px 0;
}

.navigation li:nth-child(4) {
	height: 40px;
	background-position: -568px 0;
}

.navigation li:nth-child(5) {
	height: 40px;
	background-position: -713px 0;
}

.navigation li:nth-child(6) {
	background-position: -835px 0;
	width: 245px;
	height: 95px;
	text-align: left;
}

.navigation li:first-child:hover {
	background-position: 0 -154px;
}

.navigation li:nth-child(2):hover {
	background-position: -309px -154px;
}

.navigation li:nth-child(3):hover {
	background-position: -437px -154px;
}

.navigation li:nth-child(4):hover {
	background-position: -568px -154px;
}

.navigation li:nth-child(5):hover {
	background-position: -713px -154px;
}

.navigation li:nth-child(6):hover {
	background-position: -835px -154px;
}

.navigation li:last-child:after {
	display: none;
}

.navigation li:first-child {
	padding: 28px 35px 28px 208px;
}

.navigation li:after {
	position: absolute;
	right: -4px;
	z-index: 1;
	top: 0;
	content: "";
	background: url(/img/ui/navdivider.png);
	width: 19px;
	height: 84px;
}

.navigation li:nth-child(2):after {
	background-position: -36px -166px;
}

.navigation li:nth-child(3):after {
	background-position: -72px -166px;
}

.navigation li:nth-child(4):after {
	background-position: -97px -166px;
}

.navigation li:nth-child(5):after {
	background-position: -133px -166px;
}

.navigation li {
	font-family: candara;
	font-size: 1.4rem;
	text-transform: uppercase;
	color: #ead796;
	vertical-align: inherit;
}

.navigation li:hover a {
	text-shadow: 2px 2px 6px rgba(244, 232, 191, 0.8);
}

@media only screen and (max-width: 1199px) {
	.header .container {
		max-width: 1000px;
	}

	.navigation li:nth-child(2),
	.navigation li:nth-child(3),
	.navigation li:nth-child(4),
	.navigation li:nth-child(5) {
		padding: 28px 5px;
	}

	.navigation li:first-child {
		padding: 28px 20px 28px 172px;
	}

	.navigation li:last-child {
		background-position: -873px 0;
	}

	.navigation li:last-child:hover {
		background-position: -873px -154px;
	}

	.main-content-wrap::after {
		width: 111%;
		height: 94px;
	}
}

@media only screen and (max-width: 992px) {
	.navigation li:last-child {
		background-position: -941px 0;
		padding: 28px 17px;
		width: 175px;
	}

	.navigation li:last-child:hover {
		background-position: -941px -154px;
	}

	.navigation li a {
		font-size: 1.4rem;
	}

	.navigation li:first-child {
		padding: 28px 20px 28px 167px;
	}
}

@media screen and (max-width: 767px) {
	.navigation li {
		background: none;
		width: 100% !important;
		padding: 10px 0 !important;
		height: auto !important;
		margin-left: 0;
		text-align: center !important;
	}

	.navigation li:last-child {
		width: 170px;
	}

	.navigation {
		display: v-bind(display);
		position: absolute;
		width: 100%;
		left: 0%;
		background: rgba(45, 20, 12, 0.9);
		z-index: 1;
		top: 54px;
	}

	.navigation li::after {
		display: none;
	}

	.navbar-wrap {
		height: 100px;
		padding-bottom: 36px;
		background: url(/img/ui/head.png) center top no-repeat;
		-webkit-background-size: 100% 100%;
		background-size: 100% 100%;
	}

	#menu {
		display: inline-block;
		position: absolute;
		left: 50%;
		transform: translateX(-50%);
		top: 17px;
	}
}
</style>