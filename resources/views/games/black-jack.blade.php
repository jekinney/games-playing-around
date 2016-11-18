@extends('layouts.app')

@section('content')
	<div v-if="ready">

		<div class="panel panel-default">
			<header class="panel-heading text-center">
				<h2 class="panel-title">Dealer</h2>
				<span v-text="dealer.meta.face_value"></span>
				<span v-if="dealer.meta.ace_value > 0">
					/ @{{ dealer.count.aces }}
				</span>
			</header>
			<section class="panel-body text-center">
				<img v-for="deal in dealer" :src="deal.image" class="img-responsive col-sm-2">
			</section>
		</div>
		
		<div class="panel panel-default">
			<header class="panel-heading text-center">
				<h2 class="panel-title" v-text="key"></h2>
				<span v-text="player.meta.face_value"></span>
				<span v-if="player.meta.ace_value > 0">
					/ @{{ player.meta.ace_value }}
				</span>
			</header>
			<section class="panel-body text-center">
				<img v-for="hand in player" :src="hand.image" class="img-responsive col-sm-2">
			</section>
			<footer class="panel-footer text-center">
				<button type="button" @click="playerStaying" class="btn btn-danger">Stay</button>
				<button type="button" @click="playerHit" class="btn btn-success">Hit</button>
			</footer>
		</div>
	
	</div>
	<div v-else class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-primary">
				<section class="panel-body text-center">
					<form @submit.prevent="startGame" class="form-inline">
						<div class="form-group">
							<input type="number" v-model="bet" class="form-control">
						</div>
						<button type="submit" class="btn btn-primary">Deal</button>
					</form>
				</section>
			</div>
		</div>
	</div>

@endsection

@section('script')
	<script>
		new Vue({
			el: '#app',
			data: {
				ready: false,
				player: {},
				dealer: {},
				key: null,
				bet: 5,
				chips: 1000
			},
			methods: {
				setData: function(data) {
					this.key = data.key;
					this.player = data.player;
					this.dealer = data.dealer;
					return this.ready = true;
				},
				startGame: function() {
					if(this.bet < this.chips) {
						this.$http.post('/api/black-jack/start', {bet: this.bet, chips: this.chips})
						.then(function(response) {
							this.setData(response.data);
						})
					}
				},
				playerStaying: function() {
					var data = {key: this.key};
					this.$http.post('/api/black-jack/stay', data)
					.then(function(response) {
						this.setData(response.data);
					});
				},
				playerHit: function() {
					var data = {key: this.key};
					this.$http.post('/api/black-jack/hit', data)
					.then(function(response) {
						this.key = response.data.key;
						this.hands = response.data.hands;
					});
				},
			}
		})
	</script>
@endsection