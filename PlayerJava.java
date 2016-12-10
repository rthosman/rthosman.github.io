package Battleship;

public class Player {
	public String[][] Player_Board;
	public String[][] Ship_Board;
	public Ship[] ShipsArray = new Ship[5];
	public String Name;
	public int turns; // Total Turns
	public int moves = 0; // Moves Taken
	public int turns_remaining = turns;
	public int ships_remaining = 5;
	public double hits = 0; // # of hits
	public double accuracy; // Accuracy Percentage

	public void SetupPlayer() {
		MakeShips();
		turns_remaining = turns;
	}
	
	// Fills Ship Arrays with ship details.
	public void MakeShips() {
		ShipsArray = new Ship[] { new Ship("Carrier", 5),
				new Ship("Battleship", 4), new Ship("Destroyer", 3),
				new Ship("Submarine", 3), new Ship("Patrol Ship", 2) };
	}

	public int GetTurns() {
		return turns;
	}

	public void EndTurn() {
		moves++;
		turns_remaining--;
	}

	public int GetRem() {
		return turns_remaining;
	}

	public double GetAcc() {
		if (moves == 0)
			accuracy = 0;
		else
			accuracy = ((hits / moves) * 100);
		return accuracy;
	}
}