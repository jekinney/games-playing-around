@extends('layouts.app')

@section('content')
	<main id="blackjack">
		<div v-if="ready">

			<div class="panel panel-default">
				<header class="panel-heading text-center">
					<h2 class="panel-title">Dealer</h2>
				</header>
				<section class="panel-body text-center">
					<img v-for="card in dealer" :src="card.image" class="img-responsive col-sm-2">
				</section>
			</div>
			
			<div class="panel panel-default">
				<header class="panel-heading text-center">
					<h2 class="panel-title" v-text="key"></h2>
					<span v-text="playerMeta.base_total"></span> 
					| <span v-text="playerMeta.alt_total"></span>
					<p>Chip Balance <span v-text="chips"></span></p>
				</header>
				<section class="panel-body text-center">
					<img v-for="card in player" :src="card.image" class="img-responsive col-sm-2">
				</section>
				<footer v-if="!gameover" class="panel-footer text-center">
					<button type="button" @click="playerStay" class="btn btn-danger">Stay</button>
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
	</main>
@endsection

@section('script')
	<script>
		new Vue({
			el: '#blackjack',
			data: {
				ready: false,
				player: {},
				playerMeta: {},
				dealer: {},
				dealerMeta: null,
				status: null,
				key: null,
				bet: 5,
				chips: 1000,
				gameover: false
			},
			methods: {
				startGame: function() {
					var data = {bet: this.bet};
					if(this.key != null) {
						data.key = this.key;
					}
					if(this.bet < this.chips) {
						this.$http.post('/api/black-jack/start', data)
						.then(function(response) {
							this.setData(response.data);
							this.ready = true;
							return;
						});
					}
				},
				playerStay: function() {
					this.$http.post('/api/black-jack/stay', {key: this.key})
					.then(function(response) {
						this.dealer = response.data.hand;
						this.dealerMeta = response.data.meta;
						this.checkMeta(this.dealerMeta);
					});
				},
				playerHit: function() {
					this.$http.post('/api/black-jack/hit', {key: this.key})
					.then(function(response) {
						this.player = response.data.hand;
						this.playerMeta = response.data.meta;
						this.checkMeta(this.playerMeta);
					});
				},
				setData: function(data) {
					this.key = data.game;
					this.player = data.player.hand;
					this.playerMeta = data.player.meta;
					this.checkMeta(this.playerMeta);
					this.dealer = data.dealer.hand;
					this.dealerMeta = data.dealer.meta;
					this.checkMeta(this.dealerMeta);
				},
				setAlert: function(meta) {
					if(this.gameover) {
						var that = this;
						new swal({
							title: meta.title,
							text: meta.message, 
							confirmButtonColor: "#DD6B55",
  							confirmButtonText: "Play Again",
  							closeOnConfirm: true
						}, function() {
							return that.ready = false;
						});
					}
				},
				checkMeta: function(meta) {
					if(meta) {
						if( meta.gameover) {
							this.gameover = true;
							return this.setAlert(meta); 
						} else if(meta.dealer && meta.round > 1) {
							this.playerStay();
						}
					}
					return this.gameover = false;
				},
			}
		});
	</script>
@endsection