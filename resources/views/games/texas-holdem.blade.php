@extends('layouts.app')

@section('content')
	<main id="texas">
		<div v-if="ready">

			<div  class="row">
				<div class="col-sm-12 col-md-8 col-md-offset-2">
					<section class="panel panel-primary">
						<header class="panel-heading text-center">
							<h2 class="panel-title" v-text="flop.title"></h2>
						</header>
						<ul class="list-inline">
							<li v-for="card in dealer">
								<img :src="card.image" class="img-responsive" style="max-width:150px;">
							</li>
						</ul>
					</section>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 col-md-4 col-md-offset-4">
					<section class="panel panel-primary">
						<header class="panel-heading text-center">
							<h2 class="panel-title"> Your hand</h2>
						</header>
						<article class="panel-body text-center">
						<ul class="list-inline">
							<li v-for="card in player">
								<img :src="card.image" class="img-responsive" style="max-width:150px;">
							</li>
						</ul>
						</article>
						<footer class="panel-footer text-center">
							<button type="button" @click="fold" class="btn btn-danger">Fold</button>
							<button type="button" @click="hold" class="btn btn-primary">Hold</button>
							<button type="button" @click="bet" class="btn btn-success">Bet</button>
						</footer>
					</section>
				</div>
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
			el: '#texas',
			data: {
				ready: false,
				key: null,
				bet: 5,
				player: {},
				playerTurn: true,
				flop: {
					title: 'Pre Flop',
					round: 1
				},
				current: {
					bet: 0,
					coins: 1000
				}
			},
			methods: {
				startGame: function() {
					this.$http.post('/api/texas-holdem/start', {bet: this.bet})
					.then(function(response) {
						this.key = response.data.game;
						this.player = response.data.player;
						this.ready = true;
						this.updateCurrentData();
						return;
					});
				},
				fold: function() {
					var that = this;
					new swal({
						title: 'Are you sure?',
						text: 'Folding will mean the house wins.',
						showCancelButton: true,
  						confirmButtonColor: "#DD6B55",
  						confirmButtonText: "Yes, I want to fold!",
  						closeOnConfirm: false
					}, function() {
						that.submitFold();
					});
				},
				hold: function() {
					this.$http.post('/api/texas-holdem/round', {key: this.key, bet: this.current.bet})
					.then(function(response) {
						this.dealer = {};
						this.dealer = response.data;
						this.updateFlop();
						console.log(this.dealer, response.data);
					});
				},
				bet: function() {
					this.$http.post('/api/texas-holdem/round', {key: this.key, bet: this.current.bet})
					.then(function(response) {
						this.dealer = response.data;
						this.updateFlop();
					});
				},
				submitFold: function() {

				},
				updateCurrentData: function() {
					this.current.chips = this.current.chips - this.bet;
					this.current.bet = this.current.bet + this.bet;
					this.bet = 5;
					return;
				},
				updateFlop: function() {
					if(this.dealer.length == 3) {
						this.flop = {
							title: 'The Flop',
							round: 2
						};
					} else if(this.dealer.length == 4) {
						this.flop = {
							title: 'The Middle',
							round: 3
						};
					} else if(this.dealer.length == 5) {
						this.flop = {
							title: 'The River',
							round: 3
						};
					} else {
						this.flop = {
							title: 'Pre flop',
							round: 3
						};
					}
				}
			}
		});
	</script>
@endsection