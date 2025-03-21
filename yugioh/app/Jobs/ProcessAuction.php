<?php

namespace App\Jobs;

use App\Models\Receipt;
use App\Models\OwnedItem;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAuction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $auction;

    public function __construct()
    {
    }

    public function handle()
    {
        $currentDateTime = Carbon::now();
        $auctions = Receipt::where('CategoryReceiptID', 1)
                           ->where('State', 1)
                           ->get();
    
        foreach ($auctions as $auction) {
            $auctionDateTime = Carbon::parse($auction->RecieptDate);
            if ($currentDateTime->greaterThanOrEqualTo($auctionDateTime->addSeconds(10))) {
                foreach ($auction->recieptdetail as $detail) {
                    $this->decreaseQuantityForSeller($auction->UserIDSell, $detail);
                    $this->increaseQuantityForBuyer($auction->UserIDBuy, $detail);
                }
                $auction->State = 0;
                $auction->save();
            }
        }
    }
    

    public function increaseQuantityForBuyer($auction, $detail)
    {
        $ownedItemBuy = OwnedItem::where('OwnerID', $auction)
            ->where('ItemID', $detail->ItemID)
            ->first();

        if ($ownedItemBuy) {
            $ownedItemBuy->Quantity += $detail->Quantity;
            $ownedItemBuy->save();
        } else {
            OwnedItem::create([
                'OwnerID' => $auction,
                'ItemID' => $detail->ItemID,
                'NgaySoHuu' => Carbon::now(),
                'Quantity' => $detail->Quantity,
            ]);
        }
    }

    protected function decreaseQuantityForSeller($auction, $detail)
    {
        $ownedItemSell = OwnedItem::where('OwnerID', $auction)
            ->where('ItemID', $detail->ItemID)
            ->first();

        if ($ownedItemSell) {
            $ownedItemSell->Quantity -= $detail->Quantity;
            if ($ownedItemSell->Quantity === 0) {
                $ownedItemSell->delete();
            } else {
                $ownedItemSell->save();
            }
        }
    }
}
