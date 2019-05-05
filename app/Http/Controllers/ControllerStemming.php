<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stemming;

class ControllerStemming extends Controller
{

    function cekKamus($kata)
    {
        $kataAsal = $kata;
        $data = Stemming::where('katadasar',$kata)->count();
        if($data == 1){
            return true;
        } else {
            return false;
        }
    }

    // Hapus Inflection Suffixes (“-lah”, “-kah”, “-ku”, “-mu”, atau “-nya”)
	function Del_Inflection_Suffixes($kata){
		$kataAsal = $kata;
		if(preg_quote('([km]u|nya|[kl]ah|pun)$',$kata)){ // Cek Inflection Suffixes
			$__kata = preg_replace('~([km]u|nya|[kl]ah|pun)$~','',$kata);
			if(preg_quote('([klt]ah|pun)$',$kata)){ // Jika berupa particles (“-lah”, “-kah”, “-tah” atau “-pun”)
				if(preg_quote('([km]u|nya)$',$__kata)){ // Hapus Possesive Pronouns (“-ku”, “-mu”, atau “-nya”)
					$__kata__ = preg_replace('~([km]u|nya)$~','',$__kata);
					return $__kata__;
				}
			}
			return $__kata;
		}
		return $kataAsal;
	}
	function Cek_Rule_Precedence($kata){
		if(preg_quote('^(be)[[:alpha:]]+(lah|an)$',$kata)){ // be- dan -i
			return true;
		}
		if(preg_quote('^(di|([mpt]e))[[:alpha:]]+(i)$',$kata)){ // di- dan -an
			return true;
		}
		return false;
	}
	// Cek Prefix Disallowed Sufixes (Kombinasi Awalan dan Akhiran yang tidak diizinkan)
	function Cek_Prefix_Disallowed_Sufixes($kata){
		if(preg_quote('^(be)[[:alpha:]]+(i)$',$kata)){ // be- dan -i
			return true;
		}
		if(preg_quote('^(di)[[:alpha:]]+(an)$',$kata)){ // di- dan -an
			return true;

		}
		if(preg_quote('^(ke)[[:alpha:]]+(i|kan)$',$kata)){ // ke- dan -i,-kan
			return true;
		}
		if(preg_quote('^(me)[[:alpha:]]+(an)$',$kata)){ // me- dan -an
			return true;
		}
		if(preg_quote('^(se)[[:alpha:]]+(i|kan)$',$kata)){ // se- dan -i,-kan
			return true;
		}
		return false;
	}
	// Hapus Derivation Suffixes (“-i”, “-an” atau “-kan”)
	function Del_Derivation_Suffixes($kata){
		$kataAsal = $kata;
		if(preg_match('/(kan)$/',$kata)){ // Cek Suffixes
			$__kata = preg_replace('/(kan)$/','',$kata);
			if($this->cekKamus($__kata)){ // Cek Kamus
				return $__kata;
			}
		}
		if(preg_match('/(an|i)$/',$kata)){ // cek -kan
			$__kata__ = preg_replace('/(an|i)$/','',$kata);
			if($this->cekKamus($__kata__)){ // Cek Kamus
				return $__kata__;
			}
		}
		if($this->Cek_Prefix_Disallowed_Sufixes($kata)){
			return $kataAsal;
		}
		return $kataAsal;
	}
	// Hapus Derivation Prefix (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”)
	function Del_Derivation_Prefix($kata){
		$kataAsal = $kata;
		/* ------ Tentukan Tipe Awalan ------------*/
		if(preg_match('/^(di|[ks]e)\S{1,}/',$kata)){ // Jika di-,ke-,se-
			$__kata = preg_replace('/^(di|[ks]e)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^([^aiueo])e\\1[aiueo]\S{1,}/i',$kata)){ // aturan  37
			$__kata = preg_replace('/^([^aiueo])e/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^([tmbp]e)\S{1,}/',$kata)){ //Jika awalannya adalah “te-”, “me-”, “be-”, atau “pe-”
			/*------------ Awalan “be-”, ---------------------------------------------*/
			if(preg_match('/^(be)\S{1,}/',$kata)){ // Jika awalan “be-”,
				if(preg_match('/^(ber)[aiueo]\S{1,}/',$kata)){ // aturan 1.
					$__kata = preg_replace('/^(ber)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(ber)/','r',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(ber)[^aiueor][[:alpha:]](?!er)\S{1,}/',$kata)){ //aturan  2.
					$__kata = preg_replace('/^(ber)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(ber)[^aiueor][[:alpha:]]er[aiueo]\S{1,}/',$kata)){ //aturan  3.
					$__kata = preg_replace('/^(ber)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^belajar\S{0,}/',$kata)){ //aturan  4.
					$__kata = preg_replace('/^(bel)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(be)[^aiueolr]er[^aiueo]\S{1,}/',$kata)){ //aturan  5.
					$__kata = preg_replace('/^(be)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			}
			/*------------end “be-”, ---------------------------------------------*/
			/*------------ Awalan “te-”, ---------------------------------------------*/
			if(preg_match('/^(te)\S{1,}/',$kata)){ // Jika awalan “te-”,

				if(preg_match('/^(terr)\S{1,}/',$kata)){
					return $kata;
				}
				if(preg_match('/^(ter)[aiueo]\S{1,}/',$kata)){ // aturan 6.
					$__kata = preg_replace('/^(ter)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(ter)/','r',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(ter)[^aiueor]er[aiueo]\S{1,}/',$kata)){ // aturan 7.
					$__kata = preg_replace('/^(ter)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				if(preg_match('/^(ter)[^aiueor](?!er)\S{1,}/',$kata)){ // aturan 8.
					$__kata = preg_replace('/^(ter)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				if(preg_match('/^(te)[^aiueor]er[aiueo]\S{1,}/',$kata)){ // aturan 9.
					$__kata = preg_replace('/^(te)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(ter)[^aiueor]er[^aiueo]\S{1,}/',$kata)){ // aturan  35 belum bisa
					$__kata = preg_replace('/^(ter)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			}
			/*------------end “te-”, ---------------------------------------------*/
			/*------------ Awalan “me-”, ---------------------------------------------*/
			if(preg_match('/^(me)\S{1,}/',$kata)){ // Jika awalan “me-”,

				if(preg_match('/^(me)[lrwyv][aiueo]/',$kata)){ // aturan 10
					$__kata = preg_replace('/^(me)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(mem)[bfvp]\S{1,}/',$kata)){ // aturan 11.
					$__kata = preg_replace('/^(mem)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				/*if(preg_match('/^(mempe)\S{1,}/',$kata)){ // aturan 12
					$__kata = preg_replace('/^(mem)/','pe',$kata);

					if($this->cekKamus($__kata)){

						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}*/
				if (preg_match('/^(mem)((r[aiueo])|[aiueo])\S{1,}/', $kata)){//aturan 13
					$__kata = preg_replace('/^(mem)/','m',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(mem)/','p',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(men)[cdjszt]\S{1,}/',$kata)){ // aturan 14.
					$__kata = preg_replace('/^(men)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if (preg_match('/^(men)[aiueo]\S{1,}/',$kata)){//aturan 15
					$__kata = preg_replace('/^(men)/','n',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(men)/','t',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(meng)[ghqk]\S{1,}/',$kata)){ // aturan 16.
					$__kata = preg_replace('/^(meng)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(meng)[aiueo]\S{1,}/',$kata)){ // aturan 17
					$__kata = preg_replace('/^(meng)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(meng)/','k',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(menge)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(meny)[aiueo]\S{1,}/',$kata)){ // aturan 18.
					$__kata = preg_replace('/^(meny)/','s',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(me)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			}
			/*------------end “me-”, ---------------------------------------------*/

			/*------------ Awalan “pe-”, ---------------------------------------------*/
			if(preg_match('/^(pe)\S{1,}/',$kata)){ // Jika awalan “pe-”,

				if(preg_match('/^(pe)[wy]\S{1,}/',$kata)){ // aturan 20.
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(per)[aiueo]\S{1,}/',$kata)){ // aturan 21
					$__kata = preg_replace('/^(per)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(per)/','r',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				if(preg_match('/^(per)[^aiueor][[:alpha:]](?!er)\S{1,}/',$kata)){ // aturan  23
					$__kata = preg_replace('/^(per)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(per)[^aiueor][[:alpha:]](er)[aiueo]\S{1,}/',$kata)){ // aturan  24
					$__kata = preg_replace('/^(per)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(pem)[bfv]\S{1,}/',$kata)){ // aturan  25
					$__kata = preg_replace('/^(pem)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(pem)(r[aiueo]|[aiueo])\S{1,}/',$kata)){ // aturan  26
					$__kata = preg_replace('/^(pem)/','m',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(pem)/','p',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(pen)[cdjzt]\S{1,}/',$kata)){ // aturan  27
					$__kata = preg_replace('/^(pen)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(pen)[aiueo]\S{1,}/',$kata)){ // aturan  28
					$__kata = preg_replace('/^(pen)/','n',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(pen)/','t',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(peng)[^aiueo]\S{1,}/',$kata)){ // aturan  29
					$__kata = preg_replace('/^(peng)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(peng)[aiueo]\S{1,}/',$kata)){ // aturan  30
					$__kata = preg_replace('/^(peng)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(peng)/','k',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(penge)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(peny)[aiueo]\S{1,}/',$kata)){ // aturan  31
					$__kata = preg_replace('/^(peny)/','s',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(pel)[aiueo]\S{1,}/',$kata)){ // aturan  32
					$__kata = preg_replace('/^(pel)/','l',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if (preg_match('/^(pelajar)\S{0,}/',$kata)){
					$__kata = preg_replace('/^(pel)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(pe)[^rwylmn]er[aiueo]\S{1,}/',$kata)){ // aturan  33
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(pe)[^rwylmn](?!er)\S{1,}/',$kata)){ // aturan  34
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}

				if(preg_match('/^(pe)[^aiueor]er[^aiueo]\S{1,}/',$kata)){ // aturan  36
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			}
		}
			/*------------end “pe-”, ---------------------------------------------*/
			/*------------ Awalan “memper-”, ---------------------------------------------*/
		if(preg_match('/^(memper)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(memper)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			//*-- Cek luluh -r ----------
			$__kata = preg_replace('/^(memper)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end “memper-”, ---------------------------------------------*/
		/*------------ Awalan “mempel-”, ---------------------------------------------*/
		if(preg_match('/^(mempel)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(mempel)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			//*-- Cek luluh -r ----------
			$__kata = preg_replace('/^(mempel)/','l',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end “mempel-”, ---------------------------------------------*/
		/*------------awalan  “memter-”, ---------------------------------------------*/
		if(preg_match('/^(menter)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(menter)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			//*-- Cek luluh -r ----------
			$__kata = preg_replace('/^(menter)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end “memter-”, ---------------------------------------------*/
		/*------------awalan “member-”, ---------------------------------------------*/
		if(preg_match('/^(member)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(member)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			//*-- Cek luluh -r ----------
			$__kata = preg_replace('/^(member)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end member-”, ---------------------------------------------*/
		/*------------awalan “diper-”, ---------------------------------------------*/
		if(preg_match('/^(diper)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(diper)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -r ----------*/
			$__kata = preg_replace('/^(diper)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end “diper-”, ---------------------------------------------*/
		/*------------awalan “diter-”, ---------------------------------------------*/
		if(preg_match('/^(diter)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(diter)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -r ----------*/
			$__kata = preg_replace('/^(diter)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end “diter-”, ---------------------------------------------*/
		/*------------awalan “dipel-”, ---------------------------------------------*/
		if(preg_match('/^(dipel)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(dipel)/','l',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -l----------*/
			$__kata = preg_replace('/^(dipel)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end dipel-”, ---------------------------------------------*/
		/*------------kata “terpelajar”(kasus khusus), ---------------------------------------------*/
		if(preg_match('/terpelajar/',$kata)){
			$__kata = preg_replace('/terpel/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end “terpelajar”-”, ---------------------------------------------*/
		/*------------kata seseorang(kasus khusus), ---------------------------------------------*/
		if(preg_match('/seseorang/',$kata)){
			$__kata = preg_replace('/^(sese)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
		}
		/*------------end seseorang-”, ---------------------------------------------*/
		/*------------awalan "diber-"---------------------------------------------*/
		if(preg_match('/^(diber)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(diber)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -l----------*/
			$__kata = preg_replace('/^(diber)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end "diber-"---------------------------------------------*/
		/*------------awalan "keber-"---------------------------------------------*/
		if(preg_match('/^(keber)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(keber)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -l----------*/
			$__kata = preg_replace('/^(keber)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end "keber-"---------------------------------------------*/
		/*------------awalan "keter-"---------------------------------------------*/
		if(preg_match('/^(keter)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(keter)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -l----------*/
			$__kata = preg_replace('/^(keter)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end "keter-"---------------------------------------------*/
		/*------------awalan "berke-"---------------------------------------------*/
		if(preg_match('/^(berke)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(berke)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end "berke-"---------------------------------------------*/
		/* --- Cek Ada Tidaknya Prefik/Awalan (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”) ------*/
		if(preg_match('/^(di|[kstbmp]e)\S{1,}/',$kata) == FALSE){
			return $kataAsal;
		}

		return $kataAsal;
	}
    
}
