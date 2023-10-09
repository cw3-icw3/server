<template>
	<NcModal v-if="isVisible" :show.sync="isVisible" id="global-search" :clear-view-delay="0" :title="t('Global search')"
		@close="closeModal">
		<!-- Global search form -->
		<div class="global_search_modal">
			<NcInputField :value.sync="searchQuery" type="text" :label="t('core', 'Global search')" />
			<div class="filters">
				<div class="top-apps">
					<div v-for="(appFilter, index) in userTopApps()" :class="{'top-app': true, 'active': index == 0 || index == 1}">
						<span></span><span> {{ appFilter.appName }}</span>
					</div>
				</div>
				<NcInputField :value.sync="placesFilter" type="text" :label="t('core', 'Places')" />
				<NcDateTimePicker v-model="dateTimeFilter" type="datetime" confirm />
				<NcSelect v-bind="peopleSeclectProps" v-model="peopleSeclectProps.value" />
			</div>
			<div v-for="appResult in dummyAppResults" class="results">
				<div class="result">
					<div class="result-title">
						<span>{{ appResult.appName }}</span>
					</div>
					<div class="result-items">
						<SearcResultItem v-for="result in [{}, {}, {}, {}]" />
					</div>
					<div class="result-footer">
						<NcButton type="tertiary-no-background">
							Load more results
							<template #icon>
								<DotsHorizontalIcon :size="20" />
							</template>
						</NcButton>
						<NcButton alignment="end-reverse" type="tertiary-no-background">
							Search in files
							<template #icon>
								<ArrowRight :size="20" />
							</template>
						</NcButton>
					</div>
				</div>
			</div>
		</div>
	</NcModal>
</template>

<script>
import NcButton from '@nextcloud/vue/dist/Components/NcButton.js'
import NcModal from '@nextcloud/vue/dist/Components/NcModal.js'
import NcDateTimePicker from '@nextcloud/vue/dist/Components/NcDateTimePicker.js'
import NcInputField from '@nextcloud/vue/dist/Components/NcInputField.js'
import NcSelect from '@nextcloud/vue/dist/Components/NcSelect.js'
import DotsHorizontalIcon from 'vue-material-design-icons/DotsHorizontal.vue'
import ArrowRight from 'vue-material-design-icons/ArrowRight.vue'

import SearcResultItem from '../components/GlobalSearch/SearchResultItem.vue'

export default {
	name: 'GlobalSearchModal',
	components: {
		NcButton,
		NcModal,
		NcSelect,
		NcInputField,
		ArrowRight,
		DotsHorizontalIcon,
		SearcResultItem,
		NcDateTimePicker,
	},
	props: {
		isVisible: {
			type: Boolean,
			required: true,
		},
	},
	data() {
		return {
			searchQuery: '',
			placesFilter: '',
			dateTimeFilter: null,
			dummyAppResults: [
				{ appName: 'Files' },
				{ appName: 'Talk' },
			]
		}
	},

	computed: {
		peopleSeclectProps: {
			get() {
				return {
					// inputId: getRandomId(),
					multiple: true,
					placement: 'top',
					options: this.getUsers(),
				}
			}

		}

	},
	methods: {
		closeModal() {
			this.isVisible = false
		},
		userTopApps() {
			return [
				{ appName: 'Files', icon: '' },
				{ appName: 'Talk', icon: '' },
				{ appName: 'Mail', icon: '' },
			]
		},
		getUsers() {
			return [
				'foo',
				'bar',
				'baz',
				'qux',
				'quux',
			]
		},
	},
}
</script>

<style lang="scss" scoped>
.global_search_modal {
	padding: 10px 20px 10px 20px;

	& .filters {
		display: flex;
		padding-top: 5px;
		justify-content: space-between;

		& .top-apps {
			display: flex;
			align-items: center;
			flex: 1;

			& .top-app {
				margin-right: 2px;
				padding: 4px 6px 4px 6px;
				border-radius: 10px;

				&.active {
					color: var(--color-main-background);
					background-color: var(--color-primary-element);
				}
			}
		}
	}

	& .results {
		padding: 10px;

		& .result {

			& .result-title {
				span {
					color: var(--color-primary-element);
					font-weight: bolder;
					font-size: 16px;
				}
			}

			& .result-footer {
				justify-content: space-between;
				align-items: center;
				display: flex;
			}
		}

	}
}
</style>
